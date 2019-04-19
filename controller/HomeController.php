<?php

class HomeController extends Controller
{
    /**
     * @throws Exception
     */
    public function getIndex()
    {
        //if coming from grant list, set the grant in session
        $grant_id = input('id');
        if($grant_id != null) {
            $ds = DataService::getInstance();
            $grants = $ds->getGrantsByUser(Session::getUser()->id);
            foreach ($grants as $grant) {
                if($grant->id == $grant_id) {
                    Session::setGrant($grant);
                }
            }
            if(Session::getGrant() == null)
                throw new Exception("User does not have access to grant with ID: ".$grant_id);
        }

        $view = new View('home/index.php');
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function getGrantlist()
    {
        $ds = DataService::getInstance();
        $view = new View('home/grantlist.php');
        $view->grants = $ds->getGrantsByUser(Session::getUser()->id);
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function getClient()
    {
        $ds = DataService::getInstance();
        $client = $ds->getClient(input('id'));
        if($client == null || $client->grant_id != Session::getGrant()->id)
            throw new Exception('Client ID invalid.');

        $episodes = $ds->getClientEpisodesWithGPRAs($client->id);

        $view = new View('home/client.php');
        $view->client = $client;
        $view->episodes = $episodes;
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function postAddClient() {
        $uid = input('uid');
        //TBD validate ID

        $ds = DataService::getInstance();
        $client_id = $ds->addClient($uid, Session::getGrant()->id);
        if($client_id == null) {
            flash('result', new Result(false, 'A client with this ID already exists.'));
            redirect('/');
        }
        else {
            $ds->addEpisode($client_id);
            redirect('/home/client?id=' . $client_id);
        }
    }

    /**
     * @throws Exception
     */
    public function postSearchClients() {
        $data = ajax_input();
        $uid = $data[0];
        $recentOnly = $data[1];
        $ds = DataService::getInstance();
        $clients = $ds->searchClients($uid, Session::getGrant()->id, $recentOnly);
        ajax_output(true, $clients);
    }

    /**
     * @throws Exception
     */
    public function postAddEpisode() {
        $data = ajax_input();
        $client_id = $data[0];
        $ds = DataService::getInstance();
        $episode_id = $ds->addEpisode($client_id);

        if(!($episode_id > 0)) {
            ajax_output(false, "Episode creation failed.");
        }
        else {
            ajax_output(true);
        }
    }
}