<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TrelloApi
{
    private $baseUrl = 'https://api.trello.com/1';
    private $apiKey = '0b5cfd9c65673ebefc6702a753ab9b8f';
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getBoardsByMember($id){
        return Http::get($this->baseUrl . "/members/$id/boards?key=$this->apiKey&token=$this->token")->json();
    }

    public function getListsByBoard($id) {
        return Http::get($this->baseUrl . "/boards/$id/lists?key=$this->apiKey&token=$this->token")->json();
    }

    public function getCardsByBoard($id) {
        return Http::get($this->baseUrl . "/boards/$id/cards?key=$this->apiKey&token=$this->token")->json();
    }

    public function getCommentsByCard($id) {
        return Http::get($this->baseUrl . "/cards/$id/actions?filter=commentCard&key=$this->apiKey&token=$this->token")->json();
    }

    public function getMembersOfCard($id) {
        return Http::get($this->baseUrl . "/cards/$id/members?key=$this->apiKey&token=$this->token")->json();
    }
}
