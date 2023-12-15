<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Serializer\SerializerInterface;
use App\Document\Elecgaz;



class ApiController extends AbstractController
{

    private $documentManager;
    private $serializer;

    public function __construct(DocumentManager $documentManager, SerializerInterface $serializer) {
        $this->documentManager = $documentManager;  
        $this->serializer = $serializer;
    }


    /**
     * 
     * Récupère tous les enregistrements
     * 
     * @return Response
     * @api
     */    
    #[Route('/elec', name: 'elec_all', methods:['GET'])]
    public function all(): Response
    {
        $station = $this->documentManager->getRepository(Elecgaz::class)->findBy(
            array(),
            array('id' => 'DESC'),
            50,
            0
        );;
        return $this->json($station);
    }

    #[Route('/elec/{id}', name: 'elec_id', methods:['GET'])]
    public function getById($id): Response {
        $station = $this->documentManager->getRepository(Elecgaz::class)->find($id);
        
        if ($station) {
            return $this->json($station);
        } else {
            return $this->json(["error" => "Elecgaz was not found by id:" . $id], 404);
        }
    }

    #[Route('/elec', name: 'elec_create', methods:['POST'])]
    public function create(Request $request): Response {
        $station =  $this->serializer->deserialize($request->getContent(), Elecgaz::class, 'json');

        $this->documentManager->persist($station);
        $this->documentManager->flush();

        return $this->json([], 201, ["Location" => "/api/" . $station->getId()]);
    }

    #[Route('/elec/{id}', name: 'elec_update', methods:['PUT'])]
    public function update(Request $request, $id): Response {
        
        $station = $this->documentManager->getRepository(Elecgaz::class)->find($id);
        
        if (!$station) {
            return $this->json(["error" => "Station was not found by id:" . $id], 404);
        }

        $arrayStationU = json_decode($request->getContent(),true);
        $arrayStation = json_decode($this->serializer->serialize($station, 'json'),true);
        
        $documentU = $this->serializer->deserialize(
                json_encode(array_replace_recursive($arrayStation,$arrayStationU)),
                Station::class, 'json');

        $this->documentManager->merge($documentU);
        $this->documentManager->flush();

        return $this->json([], 204);
    }

    #[Route('/elec/{id}', name: 'elec_delete', methods:['DELETE'])]
    public function deleteById($id): Response {
        $station = $this->documentManager->getRepository(Elecgaz::class)->find($id);
        
        if ($station) {
            $this->documentManager->remove($station);
            $this->documentManager->flush();
            return $this->json([], 204);
        } else {
            return $this->json(["error" => "Station was not found by id:" . $id], 404);
        }
    }
    
    #[Route('/elecgaz/{filter}/{value}', name: 'prix_filter', methods:['GET'])]
    public function filter($filter,$value): Response {
        $station = $this->documentManager->getRepository(Elecgaz::class)->getElecgazByPrix($filter,$value);

        return $this->json($station);
    }
    /**
     * @param Request $request
     * @return Response
     */
    
    // Création des routes
//    GET /stations Toutes les stations et 200 
//    GET /stations/{id} Une station par id et 200, si n'est pas trouvé retourne 404
//    POST /stations Créer une nouvelle station retourne 201
//    DELETE /stations/{id} Supprime une station par son id, retourne 204

        #[Route('/hello', name: 'hello', methods:['GET'])]
    public function sayHello(Request $request): Response
    {
//      L’opérateur fusion null ?? ressemble dans sa syntaxe et dans son fonctionnement à l’opérateur ternaire.
//      si get('name') est null alors défini Symfony par défaut
        $name = $request->get('name') ?? 'Symfony';
//        $data = ['message' => 'hello '.$name];
        

//        return new JsonResponse($data, 200, [], true);
        return $this->json($name);
    }
}
