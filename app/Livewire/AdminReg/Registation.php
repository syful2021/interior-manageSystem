<?php

namespace App\Livewire\AdminReg;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Registation extends Component
{
    use WithPagination;
    public $name, $email, $password, $Cpassword, $update_id, $isModal = false, $delete_id, $roles = [], $allRoles = [], $userRoles;
    protected $listeners = ['deleteConfirm' => 'deleteStudent'];

    public function render()
    {
        $users = User::where('role', 1)->paginate(20);
        $this->allRoles = Role::pluck('name', 'name')->all();
        return view('livewire.admin-reg.registation', compact('users'));
    }
    public function insert(){
        $validated = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|same:Cpassword',
            'roles' => 'required',
        ]);
        $done = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'created_at' => Carbon::now(),
        ]);

        $done->syncRoles($this->roles);

        if($done){
            $this->resetForm();
            $this->removeModal();
            $this->dispatch('swal', [
                'title' => 'Data Insert Successfull',
                'type' => "success",
            ]);
        }
    }
    public function ShowUpdateModel($id){
        $this->isModal = true;
        $data = User::findOrFail($id);
        $this->update_id = $data->id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->userRoles = $data->roles->pluck('name', 'name')->all();
    }
    public function update(){
        $validated = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'roles' => 'required',
        ]);
        $user = User::findOrFail($this->update_id);
        $done = $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'updated_at' => Carbon::now(),
        ]);

        $user->syncRoles($this->roles);

        if($done){
            $this->update_id = '';
            $this->resetForm();
            $this->removeModal();
            $this->dispatch('swal', [
                'title' => 'Data Update Successfull',
                'type' => "success",
            ]);
        }
    }
    public function deleteAlert($id){
        $this->delete_id = $id;
        $this->dispatch('confirmDeleteAlert');
    }
    public function deleteStudent(){
        $done = User::findOrFail($this->delete_id)->delete();
        if($done){
            $this->update_id = '';
            $this->dispatch('deleteSuccessFull', [
                'title' => 'Data Deleted Successfull',
                'type' => "success",
            ]);
        }
    }
    public function showModal(){
        $this->resetForm();
        $this->isModal = true;
    }
    public function removeModal(){
        $this->update_id = '';
        $this->isModal = false;
        $this->resetForm();
    }
    public function resetForm(){
        $this->reset(['name']);
        $this->reset(['email']);
        $this->reset(['password']);
        $this->reset(['Cpassword']);
        $this->reset(['roles']);
    }
}
