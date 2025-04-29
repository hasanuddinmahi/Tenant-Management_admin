<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Services\TenantService;

class TenantController extends Controller
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function index()
    {
        $tenants = Tenant::latest()->get();
        return view('tenant.index', compact('tenants'));
    }

    public function create()
    {
        return view('tenant.create');
    }

    public function store(StoreTenantRequest $request)
    {
        $this->tenantService->createTenant($request->validated());

        return to_route('tenant.index')->with('success', 'Tenant added successfully!');
    }

    public function show(Tenant $tenant)
    {
        return view('tenant.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        return view('tenant.edit', compact('tenant'));
    }

    public function update(UpdateTenantRequest $request, Tenant $tenant)
    {
        $this->tenantService->updateTenant($tenant, $request->validated());

        return to_route('tenant.show', $tenant)->with('success', 'Tenant updated successfully!');
    }

    public function destroy(Tenant $tenant)
    {
        $this->tenantService->deleteTenant($tenant);

        return to_route('tenant.index')->with('success', 'Tenant deleted successfully.');
    }
}
