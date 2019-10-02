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
        $ds = DataService::getInstance();
        if($grant_id != null) {
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
        $view->users = $ds->getUsersByGrant(Session::getGrant()->id);
        $view->clients = $ds->getClientsByGrant(Session::getGrant()->id);
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
        $ds = DataService::getInstance();
        $client_id = $ds->addClient(Session::getGrant()->id);
        $ds->addEpisode($client_id);
        redirect('/home/client?id=' . $client_id);
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