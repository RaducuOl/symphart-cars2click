<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\League;
Use App\Entity\Country;
Use App\Entity\Team;
Use App\Entity\Score;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class GameController extends Controller{
    /**
     * @Route("/", name="game_list")
     * @Method({"GET"})
     */
    public function index(){
        $games = $this->getDoctrine()->getRepository(Game::class)->findAll();
        $teams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        // $scores = $this->getDoctrine()->getRepository(Score::class)->findAll();
        return $this->render('games/index.html.twig',array('games'=>$games));
    }

    /**
     * @Route("/game/today/list", name="game_list_today")
     * @Method({"GET"})
     */
    public function indexGames(){
        $games = $this->getDoctrine()->getRepository(Game::class)->findAll();
        $teams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        // $scores = $this->getDoctrine()->getRepository(Score::class)->findAll();
        return $this->render('games/index-games.html.twig',array('games'=>$games,'teams'=>$teams));
    }

    /**
     * @Route("/game/new", name="new_game")
     * @Method({"GET","POST"})
     */
    public function newGame(Request $request){
        $game = new Game();
        //creeam un form pt noul joc
        $form = $this->createFormBuilder($game)
        ->add('title',TextType::class,array('attr'=>array('class'=>'form-control')))
        ->add('body',TextareaType::class,array('required'=>false,'attr'=>array('class'=>'form-control')))
        ->add('save',SubmitType::class,array('label'=>'Create','attr'=>array('class'=>'btn btn-primary mt-3')))
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $game = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('game_list');
        }
        return $this->render('games/new.html.twig',array('form'=>$form->createView()));
    }

    /**
     * @Route("/game/edit/{id}", name="edit_game")
     * @Method({"GET","POST"})
     */
    public function editGame(Request $request,$id){
        $game = new Game();
        $game = $this->getDoctrine()->getRepository(Game::class)->find($id);

        //creeam un form pt noul joc
        $form = $this->createFormBuilder($game)
        ->add('title',TextType::class,array('attr'=>array('class'=>'form-control')))
        ->add('body',TextareaType::class,array('required'=>false,'attr'=>array('class'=>'form-control')))
        ->add('save',SubmitType::class,array('label'=>'Update','attr'=>array('class'=>'btn btn-primary mt-3')))
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('game_list');
        }
        return $this->render('games/edit.html.twig',array('form'=>$form->createView()));
    }

    /**
     * @Route("/game/import", name="game_import")
     */
    public function importShow(){

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api-basketball.p.rapidapi.com/games?date=2021-04-06",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: api-basketball.p.rapidapi.com",
                "x-rapidapi-key: 42a7df7423msha3a577723bc6de8p1b228ajsn83b76838acad"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $decoded = json_decode($response,true);
            // print_r($decoded['response']);
            $json_arr = $decoded['response'];
            foreach($json_arr as $arr){
                // var_dump($arr);

                $entityManager = $this->getDoctrine()->getManager();
                $game = new Game();

                //check if the League exists, if not, create it
                //add the respective game to it's League
                var_dump('1');

                if(!$this->getDoctrine()->getRepository(League::class)->findOneBy(['name' => $arr['league']['name']])){
                    $league = new League();
                    $league->setName($arr['league']['name']);
                    $game->setLeague($league);
                    // $league->addGame($game);
                    $entityManager->persist($league);
                    $entityManager->flush();
                }else{
                    $league = $this->getDoctrine()->getRepository(League::class)->findOneBy(['name' => $arr['league']['name']]);
                    $game->setLeague($league);
                    $entityManager->persist($league);
                    $entityManager->flush();
                }

                //check if the Country exists, if not, create it
                //add the respective game to it's Country
                var_dump('2');

                if(!$this->getDoctrine()->getRepository(Country::class)->findOneBy(['name' => $arr['country']['name']])){
                    $country = new Country();
                    $country->setName($arr['country']['name']);
                    // $country->addGame($game);
                    $entityManager->persist($country);
                    $entityManager->flush();
                    $game->setCountry($country);

                }else{
                    $country = $this->getDoctrine()->getRepository(Country::class)->findOneBy(['name' => $arr['country']['name']]);
                    $entityManager->persist($country);
                    $entityManager->flush();
                    $game->setCountry($country);

                }

                //check if the teams exist, if not, create them
                //link the teams to the specific Game
                var_dump('3');

                foreach($arr['teams'] as $team_arr){
                        // var_dump($team_arr);
                    if(!$this->getDoctrine()->getRepository(Team::class)->findBy(['name' => $team_arr['name']])){
                        $team = new Team();
                        $team->setName($team_arr['name']);
                        // $team->addGame($game);
                        $entityManager->persist($team);
                        $entityManager->flush();
                        // $game->addTeam($team);
                        var_dump('3.1.0');
                    }else{
                        $team = $this->getDoctrine()->getRepository(Team::class)->findOneBy(['name' => $team_arr['name']]);
                        $entityManager->persist($team);
                        $entityManager->flush();
                        var_dump('3.1.1');
                    }
                }

                //check if the scores are related to the game, if not, connect them
                $team_home = null;
                $team_away = null;
                $home_score = null;
                $away_score = null;

                //counter for Home or Away, the teams provided always come as HOME and then AWAY
                $i = 0;
                var_dump('4');

                foreach($arr['scores'] as $score_arr){

                    $score = new Score();
                    foreach($arr['teams'] as $team_arr){
                        if($team_home==null){
                            $team_home = $this->getDoctrine()->getRepository(Team::class)->findOneBy(['name' => $team_arr['name']]);
                        }else{
                            $team_away = $this->getDoctrine()->getRepository(Team::class)->findOneBy(['name' => $team_arr['name']]);
                        }
                    }
                    
                    //the results provided by the API don't always give the quarter score therefore we will only use the "total"
                    $score->setScore($score_arr['total']);
                    $entityManager->persist($score);
                    $entityManager->flush();
                    if($home_score==null){
                        $home_score = $score;
                    }else{
                        $away_score = $score;
                    }
                }
                var_dump('5');

                //finalizing the game object
                $game->setDate($arr['date']);
                $game->setTime($arr['time']);
                $game->setTimezone($arr['timezone']);
                $game->setStage($arr['stage']);
                $game->setWeek($arr['week']);
                $game->setStatus($arr['status']['long']);
                $game->setStage($arr['stage']);
                $game->addTeam($team_home);
                $game->addTeam($team_away);
                $game->addScore($home_score);
                $game->addScore($away_score);



                $entityManager->persist($game);
                $entityManager->flush();
        
                //adding the game relationship to the other entities related to it
                $home_score->setLocation('HOME');
                $away_score->setLocation('AWAY');
                if( $home_score->getTeam()==null && $away_score->getTeam()==null ){
                    $home_score->setTeam($team_home);
                    $away_score->setTeam($team_away);
                }
                // $team_home->addGame($game);
                // $team_away->addGame($game);
                $entityManager->persist($home_score);
                $entityManager->persist($away_score);
                $entityManager->flush();
                
            }
            $text = 'Data imported successufully';
            // var_dump( json_encode($response));
            return $text;
        }
    }

    /**
     * @Route("/game/{id}", name="game_show")
     */
    public function show($id){
        $game = $this->getDoctrine()->getRepository(Game::class)->find($id);
        // $game_team = $this->getDoctrine()->getRepository(Game::class)->find($id);
        // $teams = $this->getDoctrine()->getRepository(Team::class)->findBy();
        $teams = $game->getTeams();
        $team_home = $teams[0]->getName();
        $team_away = $teams[1]->getName();

        $scores = $game->getScores();
        $score_home = $scores[0]->getScore();
        var_dump($scores[1]->getScore());
        $score_away = $scores[1]->getScore();
        return $this->render('games/show.html.twig',array('game'=>$game,'current_date'=> substr($game->getDate(),0,10),'team_home'=>$team_home,'team_away'=>$team_away,'score_home'=>$score_home,'score_away'=>$score_away));
    }

    /**
     * @Route("/game/delete/{id}")
     * @Method({"DELETE"})
     */
    public function Delete(Request $request, $id){
        $game = $this->getDoctrine()->getRepository(Game::class)->find($id);

        // var_dump($game);
        // return 0;
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($game);
        $entityManager->flush();

        $response = new Response();
        $response->send();

    }

    /**
     * @Route("/game/save")
     */
    // public function save(){
    //     $entityManager = $this->getDoctrine()->getManager();

    //     $game = new Game();
    //     $game->setTitle('game 1');
    //     $game->setBody('this is body 1');

    //     //pastram ce vrem sa facem
    //     $entityManager->persist($game);
    //     //salvam
    //     $entityManager->flush();

    //     return new Response('Saves a game with the id of'.$game->getId());
    // }
}