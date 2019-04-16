<?php

class HomeController extends Controller
{
    /**
     * @throws Exception
     */
    public function getIndex()
    {
        $view = new View('home/index.php');
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function getClient()
    {
        $ds = DataService::getInstance();
        $client = $ds->getClient(input('id'));
        if($client == null)
            throw new Exception('Client ID invalid.');
        Session::setClient($client);

        $episodes = $ds->getEpisodesByClient($client->id);
        $assessments = $ds->getAssessmentsByClient($client->id);

        //group assessments by episode
        $assessment_groups = [];
        foreach ($episodes as $episode)
            $assessment_groups[$episode->id] = [];
        foreach ($assessments as $assessment)
            $assessment_groups[$assessment->episode_id][] = $assessment;

        $view = new View('home/client.php');
        $view->client = $client;
        $view->episodes = $episodes;
        $view->assessment_groups = $assessment_groups;
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function postAddClient() {
        $uid = input('uid');
        //TBD validate ID

        $ds = DataService::getInstance();
        $client_id = $ds->addClient($uid);
        if($client_id == null) {
            flash('result', new Result(false, 'A client with this ID already exists.'));
            redirect('/');
        }
        else
            redirect('/home/client');
    }

    /**
     * @throws Exception
     */
    public function postSearchClients() {
        $uid = ajax_input()[0];
        $ds = DataService::getInstance();
        $clients = $ds->searchClients($uid);
        ajax_output(true, $clients);
    }

    /**
     * @throws Exception
     */
    public function postAddEpisode() {
        $ds = DataService::getInstance();
        $episode_id = $ds->addEpisode(Session::getClient()->id);
        $episode = $ds->getEpisode($episode_id);
        if($episode == null) {
            ajax_output(false, "Episode creation failed.");
        }
        else
            ajax_output(true, $episode);
    }
}