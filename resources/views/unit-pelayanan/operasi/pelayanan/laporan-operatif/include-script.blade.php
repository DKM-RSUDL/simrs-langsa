@push('js')
    <script>
        // Multi Input Handler - Reusable untuk semua field
        class MultiInputHandler {
            constructor() {
                this.dataStore = {};
                this.init();
            }

            init() {
                // Initialize data store untuk setiap field dan load existing data
                document.querySelectorAll('[data-hidden]').forEach(hidden => {
                    const fieldName = hidden.getAttribute('data-hidden');

                    // Load existing data dari hidden input
                    const existingValue = hidden.value;
                    try {
                        this.dataStore[fieldName] = existingValue ? JSON.parse(existingValue) : [];
                    } catch (e) {
                        this.dataStore[fieldName] = [];
                    }

                    // Render existing data
                    this.render(fieldName);
                });

                // Setup event listeners untuk tombol add
                document.querySelectorAll('.multi-input-add').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const target = e.currentTarget.getAttribute('data-target');
                        this.addItem(target);
                    });
                });

                // Setup event listeners untuk enter key
                document.querySelectorAll('.multi-input-field').forEach(input => {
                    input.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            const fieldName = e.target.getAttribute('data-multi-input');
                            this.addItem(fieldName);
                        }
                    });
                });
            }

            addItem(fieldName) {
                const input = document.querySelector(`[data-multi-input="${fieldName}"]`);
                const value = input.value.trim();

                if (value !== "") {
                    this.dataStore[fieldName].push(value);
                    this.updateHiddenInput(fieldName);
                    this.render(fieldName);
                    input.value = "";
                    input.focus();
                }
            }

            removeItem(fieldName, index) {
                this.dataStore[fieldName].splice(index, 1);
                this.updateHiddenInput(fieldName);
                this.render(fieldName);
            }

            render(fieldName) {
                const listContainer = document.querySelector(`[data-list="${fieldName}"]`);
                const emptyMessage = listContainer.querySelector('.multi-input-empty');

                // Clear current list (kecuali empty message)
                Array.from(listContainer.children).forEach(child => {
                    if (!child.classList.contains('multi-input-empty')) {
                        child.remove();
                    }
                });

                // Show/hide empty message
                if (this.dataStore[fieldName].length === 0) {
                    emptyMessage.style.display = "block";
                    return;
                }
                emptyMessage.style.display = "none";

                // Render items
                this.dataStore[fieldName].forEach((item, index) => {
                    const itemDiv = document.createElement("div");
                    itemDiv.className = "d-flex justify-content-between align-items-center mb-2 gap-2 bg-white";
                    itemDiv.innerHTML = `
                        <span class="border rounded px-2 py-1 w-100">${this.escapeHtml(item)}</span>
                        <button type="button" class="btn btn-sm btn-danger" data-remove="${fieldName}" data-index="${index}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                    listContainer.appendChild(itemDiv);

                    // Add remove event listener
                    const removeBtn = itemDiv.querySelector('button');
                    removeBtn.addEventListener('click', () => {
                        this.removeItem(fieldName, index);
                    });
                });
            }

            updateHiddenInput(fieldName) {
                const hiddenInput = document.querySelector(`[data-hidden="${fieldName}"]`);
                hiddenInput.value = JSON.stringify(this.dataStore[fieldName]);
            }

            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        }

        // Initialize saat document ready
        document.addEventListener('DOMContentLoaded', function() {
            window.multiInputHandler = new MultiInputHandler();
        });
    </script>
@endpush
