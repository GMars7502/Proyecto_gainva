<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get(); // Traer roles con sus permisos
        return view('roles.index', compact('roles'));
    }

  public function create()
    {
        $permisos = Permission::all(); // obtener todos los permisos

        return view('roles.create', compact('permisos'));
}


   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name',
        'permissions' => 'required|array'
    ]);

    // Crear el nuevo rol
    $role = Role::create(['name' => $request->name]);

    // 🔄 Convertir los IDs a nombres de permisos
    $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();

    // Asignar permisos usando nombres
    $role->syncPermissions($permissionNames);

    return redirect()->route('roles.index')
        ->with('success', 'Rol creado correctamente.');
}

    public function edit($id)
       {
          $role = Role::findOrFail($id);
          $permissions = Permission::all();
          $rolePermissions = $role->permissions->pluck('id')->toArray();

          return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }


  public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|unique:roles,name,' . $id,
        'permissions' => 'required|array'
    ]);

    $role = Role::findOrFail($id);
    $role->name = $request->name;
    $role->save();

    // ✅ Convertir IDs a nombres
    $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');

    // Sincronizar permisos usando los nombres
    $role->syncPermissions($permissionNames);

    return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
}


    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente');
    }
}