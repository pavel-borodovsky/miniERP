<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TrelloApi
{
    private $baseUrl = 'https://api.trello.com/1';
    private $apiKey = '0b5cfd9c65673ebefc6702a753ab9b8f';
    private $token = 'ATTA037207c2cb1f78ad47fac31c3b379c7f6ae893fc3aaa685a44803a7680f32fbbE61C6A51';

    //todo программную авторизацию для получения токена
    /*public function __construct()
    {
        $response = Http::asForm()->get("https://trello.com/1/authorize?expiration=never&scope=read,write,account&response_type=token&name=Server%20Token&key=$this->apiKey")->json();
        dd($response);
    }*/

    public function getBoardsByMember($id){
        return Http::get($this->baseUrl . "/members/$id/boards?key=$this->apiKey&token=$this->token")->json();
    }

    public function getListsByBoard($id) {
        return Http::get($this->baseUrl . "/boards/$id/lists?key=$this->apiKey&token=$this->token")->json();
    }

    public function getCardsByBoard($id) {
        return Http::get($this->baseUrl . "/boards/$id/cards?key=$this->apiKey&token=$this->token")->json();
    }
}
