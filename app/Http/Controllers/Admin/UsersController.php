<?php

namespace SON\Http\Controllers\Admin;

use SON\User;
use Illuminate\Http\Request;
use SON\Http\Controllers\Controller;
use SON\Forms\UserForm;

class UsersController extends Controller
{
   
    public function index()
    {
        $users = User::paginate();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
       $form =  \FormBuilder::create(UserForm::class,[
            'url'=>route('admin.users.store'),
            'method'=> 'POST'
        ]);

        return view('admin.users.create', compact('form'));
    }

    public function store(Request $request)
    {
       $form =  \FormBuilder::create(UserForm::class);
       if(!$form->isValid()){
           return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
       }
       $data = $form->getFieldValues(); 
      
       User::createFully($data);

       $request->session()->flash('message','Usuário criado com sucesso');

      return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \SON\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SON\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $form =  \FormBuilder::create(UserForm::class,[
            'url'=>route('admin.users.update', ['user'=>$user->id]),
            'method'=> 'PUT',
            'model'=>$user
        ]);
        return view('admin.users.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SON\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
       $form =  \FormBuilder::create(UserForm::class, [
           'data'=>['id'=>$user->id]
       ]);

       if(!$form->isValid()){
           return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
       }
       $data = $form->getFieldValues(); 
       $user->update($data);
       session()->flash('message','Usuário atualizado com sucesso');
       return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SON\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
         session()->flash('message','Usuário excluído com sucesso');
        return redirect()->route('admin.users.index');
    }
}
