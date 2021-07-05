<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\PokemonApi;
use App\Entity\Pokemon;
use App\Entity\Ability;
use App\Entity\Type;

const ERROR = 'Something went Wrong! please Try Again!';

/**
 * @Route("/team")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/", name="team_index", methods={"GET"})
     */
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    /**
     *
     * @Route("/create", name="team_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $new_random_pokemon = $this->getNewRandomPokemon();
            
            if($new_random_pokemon != null) {
                $team->addPokemon($new_random_pokemon);
            }
            
            //salva comunque la nuova team anche se PokemonApi ha dato errori!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($team);
            $entityManager->flush();
            
            //return $this->redirectToRoute('team_index', [], Response::HTTP_SEE_OTHER);
//             return $this->renderForm('team/edit.html.twig', [
//                 'team' => $team,
//                 'form' => $form,
//             ]);
            
            return $this->redirectToRoute('team_edit', ['id' => $team->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="team_show", methods={"GET"})
     */
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="team_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            //ricava un nuovo pokemon random! e aggiungilo!
            $new_random_pokemon = $this->getNewRandomPokemon();
            
            if($new_random_pokemon != null) {
                $team->addPokemon($new_random_pokemon);
            }
            
            $this->getDoctrine()->getManager()->flush();

//            return $this->redirectToRoute('team_index', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('team_edit', ['id' => $team->getId()], Response::HTTP_SEE_OTHER);
            
            
        
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="team_delete", methods={"POST"})
     */
    public function delete(Request $request, Team $team): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_index', [], Response::HTTP_SEE_OTHER);
    }
    
    private function getNewRandomPokemon() 
    {
        $pokemon_api = new PokemonApi();
        $new_pokemon_entity = new Pokemon();
        $new_pokemon = $pokemon_api->getRandomPokemon();
    
        
        
        $new_pokemon = json_decode($new_pokemon);
        
        //gestione degli errori
        if(array_key_exists('error', $new_pokemon)) {
            echo ERROR;
            return null;
        }

        //---setta valori pokemon
        $new_pokemon_entity->setName($new_pokemon->name);
        $new_pokemon_entity->setBaseExperience($new_pokemon->base_experience);
        
        //---
        $pokemon_abilities = $new_pokemon->abilities;
        foreach ($pokemon_abilities as $ability)
        {
            $ab = $ability->ability;
            $ability_name = $ab->name;
            //---
            $ability_entity = new Ability();
            $ability_entity->setName($ability_name);
            $new_pokemon_entity->addAbility($ability_entity);
        }
        
        //---
        $pokemon_types = $new_pokemon->types;
        foreach ($pokemon_types as $type)
        {
            $tp = $type->type;
            $type_name = $tp->name;
            //---
            $type_entity = new Type();
            $type_entity->setName($type_name);
            $new_pokemon_entity->addType($type_entity);
        }
        
        return $new_pokemon_entity;
        
    }
    
    
}
