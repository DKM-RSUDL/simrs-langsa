<ul class="nav tab-minimal">

    <li class="nav-item">
        <form method="GET" action="{{ url()->current() }}">
            <input type="hidden" name="rawat_inap" value="1">

            <button type="submit"
                class="tab-link {{ $isRawatInap ? 'active' : '' }}">
                Rawat Inap
            </button>
        </form>
    </li>

    <li class="nav-item">
        <form method="GET" action="{{ url()->current() }}">
            <input type="hidden" name="rawat_jalan" value="1">

            <button type="submit"
                class="tab-link {{ $isRawatJalan ? 'active' : '' }}">
                Rawat Jalan
            </button>
        </form>
    </li>

</ul>
