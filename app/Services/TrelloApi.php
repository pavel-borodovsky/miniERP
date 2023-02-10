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

    /**
     * The Trello Api methods
     *
     * https://developer.atlassian.com/cloud/trello/rest/api-group-members/#api-members-id-boards-get
     */
    public function getBoardsByMember($id){
        return Http::get($this->baseUrl . "/members/$id/boards?key=$this->apiKey&token=$this->token")->json();
    }

    /**
     * https://developer.atlassian.com/cloud/trello/rest/api-group-boards/#api-boards-id-lists-get
     */
    public function getListsByBoard($id) {
        return Http::get($this->baseUrl . "/boards/$id/lists?key=$this->apiKey&token=$this->token")->json();
    }

    /**
     * https://developer.atlassian.com/cloud/trello/rest/api-group-boards/#api-boards-id-cards-get
     */
    public function getCardsByBoard($id) {
        return Http::get($this->baseUrl . "/boards/$id/cards?key=$this->apiKey&token=$this->token")->json();
    }

    /**
     * https://developer.atlassian.com/cloud/trello/rest/api-group-cards/#api-cards-id-actions-get
     */
    public function getCommentsByCard($id) {
        return Http::get($this->baseUrl . "/cards/$id/actions?filter=commentCard&key=$this->apiKey&token=$this->token")->json();
    }

    /**
     * https://developer.atlassian.com/cloud/trello/rest/api-group-cards/#api-cards-id-members-get
     */
    public function getMembersOfCard($id) {
        return Http::get($this->baseUrl . "/cards/$id/members?key=$this->apiKey&token=$this->token")->json();
    }
}
