<?php

namespace App\Services;

use App\Models\HrdKaryawan;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Models\Role;

class UserService
{
    public function dataTable()
    {
        // $data = UserProfile::whereHas('user.roles', function ($query) {
        //     $query->where('name', '!=', 'admin');
        // })->with('user.roles')->get();

        $data = User::with(['roles']);

        return DataTables::of($data)
            ->addIndexColumn()
            // ->addColumn('nama_user', function ($row) {
            //     return $row->name;
            // })
            // ->addColumn('roles', function ($row) {
            //     $roles = $row->roles->pluck('name')->toArray();
            //     return implode(', ', $roles);
            //     return json_decode($row->roles, true);
            // })
            ->addColumn('roles', function ($row) {
                return $row->roles->pluck('name')->implode(', ');
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . url("users", $row->id) . '/edit" name="edit" data-id="' . $row->id . '" class="editRole btn btn-warning btn-sm me-2"><i class="ti-pencil-alt"></i></a>';
                // $actionBtn .= '<button type="button" name="delete" data-id="' . $row->id . '" class="deleteUser btn btn-danger btn-sm"><i class="ti-trash"></i></button>';
                return '<div class="d-flex">' . $actionBtn . '</div>';
            })
            // ->filter(function ($query) {
            //     if (request()->has('search.value')) {
            //         $search = request('search.value');
            //         $query->where(function ($q) use ($search) {
            //             $q->where('kd_karyawan', 'like', "%$search%")
            //                 ->orWhere('name', 'like', "%$search%")
            //                 ->orWhereHas('roles', function ($q) use ($search) {
            //                     $q->where('name', 'like', "%$search%");
            //                 });
            //         });
            //     }
            // })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getById($id)
    {
        return User::findOrFail($id);
    }

    public function create($data)
    {
        // DB::beginTransaction();

        // try {
        // create user
        $user = $this->createUser($data);
        return $user;

        // create user profile
        // $this->createUserProfile($data, $user);

        // DB::commit();

        // return [
        //     'success' => true,
        //     'message' => 'Data berhasil disimpan.',
        // ];
        // } catch (\Exception $e) {
        //     // DB::rollBack();

        //     return [
        //         'success' => false,
        //         'message' => 'Gagal menyimpan data: ' . $e->getMessage()
        //     ];
        // }
    }

    public function createUser($data)
    {
        // Get karyawan data
        $karyawan = HrdKaryawan::where('kd_karyawan', $data['karyawan'])->first();

        if (empty($karyawan)) {
            return [
                'success'   => false,
                'message'   => 'Karyawan tidak ditemukan'
            ];
        }

        // check akun karyawan sudah ada atau belum
        $rmeUser = User::where('kd_karyawan', $karyawan->kd_karyawan)->first();

        if (!empty($rmeUser)) {
            return [
                'success'   => false,
                'message'   => 'Karyawan telah memiliki akun!'
            ];
        }

        $user = User::create([
            'kd_karyawan'   => $karyawan->kd_karyawan,
            'name'          => $karyawan->nama,
            'email'         => $karyawan->email,
            'password'      => bcrypt($data['password']),
        ]);

        // assign role
        $role = Role::find($data['role']);
        $user->assignRole($role);

        // return $user;
        return [
            'success' => true,
            'message' => 'Data berhasil disimpan.',
        ];
    }

    public function createUserProfile($data, $user)
    {
        $userProfile = UserProfile::create([
            'user_id' => $user->id,
            'no_hp' => $data['no_hp'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'alamat' => $data['alamat']
        ]);

        if (isset($data['image'])) {
            $image = $data['image'];
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/users'), $imageName);

            $userProfile->image = $imageName;
            $userProfile->save();
        }
    }

    public function update($data, $id)
    {
        DB::beginTransaction();

        try {
            // find user
            $user = User::findOrFail($id);

            // update user
            $this->updateUser($data, $user);

            // update user profile
            // $this->updateUserProfile($data, $user);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data berhasil diubah.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Gagal merubah data: ' . $e->getMessage()
            ];
        }
    }

    public function updateUser($data, $user)
    {
        // $user->update([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => isset($data['password']) ? bcrypt($data['password']) : $user->password,
        // ]);

        // sync role
        if (isset($data['role'])) {
            $role = Role::find($data['role']);
            $user->syncRoles([$role->id]);
        }

        return $user;
    }

    public function updateUserProfile($data, $user)
    {
        $userProfile = $user->profile;

        $userProfile->update([
            'no_hp' => $data['no_hp'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'alamat' => $data['alamat']
        ]);

        // update image
        if (isset($data['image'])) {
            if ($userProfile && $userProfile->image) {
                $oldImagePath = public_path('assets/images/users/' . $userProfile->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $data['image'];
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/users'), $imageName);

            $userProfile->image = $imageName;
            $userProfile->save();
        }

        return $userProfile;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            // find user
            $user = User::find($id);

            // find user profile
            // $userProfile = UserProfile::where('user_id', $id)->first();

            if ($user) {

                // delete user
                $this->deleteUser($user);

                // delete user profile
                // $this->deleteUserProfile($userProfile);

                // delete user roles
                $user->roles()->detach();

                DB::commit();

                return [
                    'success' => true,
                    'message' => 'Data berhasil dihapus.',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Data tidak ditemukan.',
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ];
        }
    }

    public function deleteUser($user)
    {
        return $user->delete();
    }

    public function deleteUserProfile($userProfile)
    {
        $imagePath = null;
        if ($userProfile->image) {
            $imagePath = public_path('assets/images/users/' . $userProfile->image);
        }

        $userProfile->delete();

        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}
