        <?php

        class AuthController extends \BaseController {

        	
            public function index()
            {
                $user = Sentry::getUser();
                $users =Sentry::findAllUsers();
                    return View::make('auth.index', 
                        compact('users'),
                        array('user' => $user,));
                
            }
            public function show($id)
            {
                $user = Sentry::getUser();
                $users =Sentry::findUserById($id);
                    return View::make('auth.show',
                        compact('users'),
                        array('user' => $user,));



            }
            public function destroy($id)
            {
                $users =Sentry::findUserById($id);
                $users->delete();

                Session::flash('message', 'Successfully deleted the administrators records!');
                return Redirect::route('auth.index');


            }
            public function edit($id){
                $user = Sentry::getUser();
                $users =Sentry::findUserById($id);
                    return View::make('auth.edit',
                        compact('users'),
                        array('user' => $user,));
            }
            public function update($id){
                try
                {
                    $user = Sentry::findUserById($id);
                    $user->email =Input::get('username');
                    $user->first_name = Input::get('first_name');
                    $user->last_name = Input::get('last_name');
                    $user->password = Input::get('password');

                    if ($user->save())
                    {
                        Session::flash('message', 'the admin information was successfully updated.');
                        $groups = $user->getGroups();
                        if ($user->removeGroup($groups[0]))
                        {
                            Session::flash('message', 'the admin group information was successfully deleted.');  
                        }
                        else
                        { 
                            Session::flash('message', 'the admin group information was NOT successfully deleted. Try again later.'); 
                        }

                        $group_id=Input::get('select_group');
                        $group = Sentry::findGroupById($group_id);

                        if ($user->addGroup($group))
                        {
                            Session::flash('message', 'the admin group information was successfully updated.');  
                        }
                        else
                        { 
                            Session::flash('message', 'the admin group information was NOT successfully updated. Try again later.'); 
                        }

                        return Redirect::to('auth/');
                    }
                    else
                    {
                       Session::flash('message', 'the admin information was NOT successfully updated. Try again later.');
                       return Redirect::to('auth/');
                    }
                   
                }
                catch (\Exception $e)
                {
                    Session::flash('message', $e->getMessage());
                    return Redirect::to('/');
                }
            }

        	public function getRegister(){
                $user = Sentry::getUser();
        	    return View::make('auth.register',compact('user'));
        	}

        	public function getLogin(){
                return View::make('auth.login');
        	}

        	public function postRegister(){
                try{
                    $user=Sentry::createUser(array(
                        'first_name'=>Input::get('first_name'),
                        'last_name'=>Input::get('last_name'),
                        'email'=>Input::get('username'),
                        'password'=>Input::get('password'),
                        'activated'=>true,
                    ));


                $group_id=Input::get('select_group');
                $group = Sentry::findGroupById($group_id);
                $user->addGroup($group);

                     return Redirect::to('login');

                }catch (Cartalyst\Sentry\Users\UserExistsException $e){
                     Session::flash('message', $e->getMessage());
                    return Redirect::to('register');
                     
                }

        	}
        	public function postLogin(){
                try
                {
                    $credentials = array(
                        'email'    => Input::get('username'),
                        'password' => Input::get('password'),
                    );

                    $user = Sentry::authenticate($credentials, false);

                    if($user){
                        return Redirect::to('counties');
                    }
                }
                catch (\Exception $e)
                {
                    Session::flash('message', $e->getMessage());
                    return Redirect::to('login');

                }


        	}
            public function apiLogin(){
                try
                {
                    $credentials = array(
                        'email'    => Input::get('username'),
                        'password' => Input::get('password'),
                    );

                    $user = Sentry::authenticate($credentials, false);
                    $token = hash('sha256',Str::random(10),false);

                    $user->api_token = $token;
                    $user->save();

                    if($user){
                         return Response::json(array(
                                    'error' => false,
                                    'code' => 200,
                                    'message' => array(
                                        'token'=>$token,
                                        'first_name'=> $user->first_name,
                                        'last_login'=> $user->last_login)), 200);
                    }
                }
                catch (\Exception $e)
                {
                    return Response::json(array(
                                    'error' => true,
                                    'code' => 401,
                                    'message' => 'wrong credentials'), 401);

                }


            }
            public function addUser(){
                try{
                    $user=Sentry::createUser(array(
                        'first_name'=>'admin',
                        'last_name'=>'admin',
                        'email'=>'admin@admin.com',
                        'password'=>'password',
                        'activated'=>true,
                    ));

                $group = Sentry::findGroupByName('admin');
                $user->addGroup($group);

                }catch (Cartalyst\Sentry\Users\UserExistsException $e){
                     Session::flash('message', $e->getMessage());
                     
                }

            }
            public function addUserToGroup(){
                $user = Sentry::findUserByCredentials(
                    array(
                        'email' => "admin@admin.com"  
                        ));
                $group = Sentry::findGroupByName('admin');
                $user->addGroup($group);    
            }

            public function registerGroups(){
                try{
                    $group = Sentry::findGroupByName('admin');
                    $group->delete();
                }catch(\Exception $e){

                }
                try{
                    $group = Sentry::findGroupByName('level_one');
                    $group->delete();
                }catch(\Exception $e){
                    
                }
                try{
                    $group = Sentry::findGroupByName('level_two');
                    $group->delete();
                }catch(\Exception $e){
                    
                }
                try{
                    $group = Sentry::findGroupByName('level_three');
                    $group->delete();
                }catch(\Exception $e){
                    
                }

                Sentry::getGroupProvider()->create(array(
                    'name'        => 'admin',
                    'permissions' => array(
                        'counties.create' => 1,
                        'counties.edit' => 1,
                        'counties.index' => 1,
                        'counties.show' => 1,

                        'branches.create' => 1,
                        'branches.edit' => 1,
                        'branches.index' => 1,
                        'branches.show' => 1,

                        'devices.create' => 1,
                        'devices.edit' => 1,
                        'devices.edit' => 1,
                        'devices.index' => 1,
                        'devices.show' => 1,

                        'inventories.create' => 1,
                        'inventories.edit' => 1,
                        'inventories.index' => 1,
                        'inventories.show' => 1,

                        'issues.create' => 1,
                        'issues.edit' => 1,
                        'issues.index' => 1,
                        'issues.show' => 1,

                        'leads.create' => 1,
                        'leads.edit' => 1,
                        'leads.index' => 1,
                        'leads.show' => 1,

                        'merchants.create' => 1,
                        'merchants.edit' => 1,
                        'merchants.index' => 1,
                        'merchants.show' => 1,

                        'products.create' => 1,
                        'products.edit' => 1,
                        'products.index' => 1,
                        'products.show' => 1,
                        
                    ),
                ));

                
                Sentry::getGroupProvider()->create(array(
                    'name'        => 'level_one',
                    'permissions' => array(
                        'counties.create' => 1,
                        'counties.edit' => 1,
                        'counties.index' => 1,
                        'counties.show' => 1,

                        'branches.create' => 1,
                        'branches.edit' => 1,
                        'branches.index' => 1,
                        'branches.show' => 1,

                        'devices.create' => 1,
                        'devices.edit' => 1,
                        'devices.edit' => 1,
                        'devices.index' => 1,
                        'devices.show' => 1,

                        'inventories.create' => 1,
                        'inventories.edit' => 1,
                        'inventories.index' => 1,
                        'inventories.show' => 1,

                        'issues.create' => 1,
                        'issues.edit' => 1,
                        'issues.index' => 1,
                        'issues.show' => 1,

                        'leads.create' => 1,
                        'leads.edit' => 1,
                        'leads.index' => 1,
                        'leads.show' => 1,

                        'merchants.create' => 1,
                        'merchants.edit' => 1,
                        'merchants.index' => 1,
                        'merchants.show' => 1,

                        'products.create' => 1,
                        'products.edit' => 1,
                        'products.index' => 1,
                        'products.show' => 1,
                        
                        
                    ),
                ));

                Sentry::getGroupProvider()->create(array(
                    'name'        => 'level_two',
                    'permissions' => array(
                        'counties.create' => 1,
                        'counties.edit' => 1,
                        'counties.index' => 1,
                        'counties.show' => 1,

                        'branches.create' => 1,
                        'branches.edit' => 1,
                        'branches.index' => 1,
                        'branches.show' => 1,

                        'devices.create' => 1,
                        'devices.edit' => 1,
                        'devices.edit' => 1,
                        'devices.index' => 1,
                        'devices.show' => 1,

                        'inventories.create' => 1,
                        'inventories.edit' => 1,
                        'inventories.index' => 1,
                        'inventories.show' => 1,

                        'issues.create' => 1,
                        'issues.edit' => 1,
                        'issues.index' => 1,
                        'issues.show' => 1,

                        'leads.create' => 1,
                        'leads.edit' => 1,
                        'leads.index' => 1,
                        'leads.show' => 1,

                        'merchants.create' => 1,
                        'merchants.edit' => 1,
                        'merchants.index' => 1,
                        'merchants.show' => 1,

                        'products.create' => 1,
                        'products.edit' => 1,
                        'products.index' => 1,
                        'products.show' => 1,
                        
                        
                    ),
                ));

                Sentry::getGroupProvider()->create(array(
                    'name'        => 'level_three',
                    'permissions' => array(
                        'counties.create' => 1,
                        'counties.edit' => 1,
                        'counties.index' => 1,
                        'counties.show' => 1,

                        'branches.create' => 1,
                        'branches.edit' => 1,
                        'branches.index' => 1,
                        'branches.show' => 1,

                        'devices.create' => 1,
                        'devices.edit' => 1,
                        'devices.edit' => 1,
                        'devices.index' => 1,
                        'devices.show' => 1,

                        'inventories.create' => 1,
                        'inventories.edit' => 1,
                        'inventories.index' => 1,
                        'inventories.show' => 1,

                        'issues.create' => 1,
                        'issues.edit' => 1,
                        'issues.index' => 1,
                        'issues.show' => 1,

                        'leads.create' => 1,
                        'leads.edit' => 1,
                        'leads.index' => 1,
                        'leads.show' => 1,

                        'merchants.create' => 1,
                        'merchants.edit' => 1,
                        'merchants.index' => 1,
                        'merchants.show' => 1,

                        'products.create' => 1,
                        'products.edit' => 1,
                        'products.index' => 1,
                        'products.show' => 1,
                        
                        
                    ),
                ));

            
            }
        	public function logout(){
        	    Sentry::logout();
        	    return Redirect::to('/');

        	}
            public function init(){
                registerGroups();
                addUser();
                addUserToGroup();
            }
        }