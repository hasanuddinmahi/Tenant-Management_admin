<x-layout>
    <div class="container mt-4">
        <h2 class="mb-4">Create User</h2>

        <form action="{{ route('user.store') }}" method="POST">
            @csrf

            {{-- Basic Info --}}
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 col-md-4">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" id="password" required>
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 col-md-4">
                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">Select Role</option>
                        <option value="super-admin">Super Admin</option>
                        <option value="admin">Admin</option>
                        <option value="guest">Guest</option>
                    </select>
                    @error('role') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label">Status</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" value="1" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" value="0">
                            <label class="form-check-label">Inactive</label>
                        </div>
                    </div>
                    @error('is_active') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Access Control --}}
            <h5 class="mt-4 mb-3">Access Permissions</h5>
            @php
                $modules = ['tenant', 'apartment', 'expense', 'booking'];
                $actions = ['view', 'create', 'edit', 'delete'];
            @endphp

            <div class="row">
                @foreach ($modules as $module)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <strong>{{ ucfirst($module) }} Permissions</strong>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input toggle-module" type="checkbox" id="toggle_{{ $module }}" data-module="{{ $module }}">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($actions as $action)
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input module-checkbox module-{{ $module }}"
                                                    type="checkbox"
                                                    name="access[{{ $module }}][can_{{ $action }}]"
                                                    id="{{ $module }}_{{ $action }}"
                                                    value="1">
                                                <label class="form-check-label" for="{{ $module }}_{{ $action }}">
                                                    {{ ucfirst($action) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
<div class="col-12 mb-4">
    <button type="submit" class="btn btn-primary">Create User</button>
    <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
</div>

</form>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modules = @json($modules);

            modules.forEach(module => {
                const toggle = document.getElementById(`toggle_${module}`);
                const checkboxes = document.querySelectorAll(`.module-${module}`);

                // Toggle all
                toggle.addEventListener('change', function () {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });

                // Update parent toggle if children changed
                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function () {
                        const allChecked = Array.from(checkboxes).every(c => c.checked);
                        toggle.checked = allChecked;
                    });
                });
            });
        });
    </script>
@endpush
</x-layout>
