<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client as Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c = Client::all();
        return $c;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Client::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $c = Client::find($id);
        return $c;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*
        nao achei aonde poderia mandar uma msg pra vcs. gostaria de saber se tem 
        como agilizar o processo de liberaçao dos modulos. ja tenho conhecimento 
        de laravel 5.1(fiz o curso do vedoveli) e angular(estudei so). Não disponho de 
        tempo(to virando a noite) e preciso da liberação rapida pois irei usar em uma 
        nova aplicação que. 
        meu interesse em contratar era mais saber como integrar os 2 de forma correta 
        e tbm pela parte da seguraça da api rest desenvolvida. tenho que evitar que a 
        api seja consumida diretamente - sem ser por request interna do sistema.
        */

        $client = $this->show($id);
        $client->fill($request->all())->save();

        /*
        tentei fazer de varias formas e sempre tava dando o erro citado.
        dessa forma foi sem erro. se tiver alguma melhor de ser aplicada me informe
        */
        return [$client];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::find($id)->delete();
    }

}
