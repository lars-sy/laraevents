<?php

namespace App\Http\Controllers\Organization\Event;

use App\Http\Controllers\Controller;
Use App\Models\{Event, User};
Use App\Services\EventService;
use Illuminate\Http\Request;

class EventSubscriptionController extends Controller
{
    public function store(Event $event, Request $request){
        $user = user::findOrFail($request->user_id);

        if(EventService::userSubscribedOnEvent($user, $event)){
            return back()->with('warning', 'Este participante já está inscrito no evento');
        }

        if(EventService::eventEndDateHasPassed($event)){ 
            return back()->with('warning', 'Operação inválida! O evento já ocorreu.');
        }

        if(EventService::eventParticipantsLimitHasReached($event)){ 
            return back()->with('warning', 'Não é possível inscrever o participante no evento, pois o limite de participantes foi atingido.');
        }

        $user->events()->attach($event->id); //cria a inscricao do user no evneto passado no parametro

        return back()->with('success', 'Inscrição no evento realizada com sucesso!');
    }

    public function destroy(Event $event, User $user)
    {
        if(EventService::eventEndDateHasPassed($event)){ 
            return back()->with('warning', 'Operação inválida! O evento já ocorreu.');
        }

        if(!EventService::userSubscribedOnEvent($user, $event)){
            return back()->with('warning', 'O participante não está inscrito no evento.');
        }

        $user->events()->detach($event->id);

        return back()->with('success', "Inscrição no evento removida com sucesso!");
    }

}
