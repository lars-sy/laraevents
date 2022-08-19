<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\{User, Address};
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function create(){
        return view('auth.register');
    }

    public function store(RegisterRequest $request){ //adicionar manualmente o import, use app\models\user
        $requestData = $request->validated();

        $requestData['user']['role'] = 'participant';

        DB::beginTransaction(); //inicia a transacao do banco de dados
        try {
            $user = User::create($requestData['user']); 
            

            $user->address()->create($requestData['address']); //cadastro do address do user a partir do relacionamento craido em user.php

            foreach ($requestData['phones'] as $phone){
                $user->phones()->create($phone);
            }

            DB::commit(); //só ira efetivar o DB se executar o commit

            return redirect()->route('auth.login.create')->with('success', 'Conta criada com sucesso! Efetue login');
        } catch (\Exception $exception) {
            //caso de erro
            DB::rollBack();
            return "Mensagem ".$exception->getMessage();
        }    
    }
}


