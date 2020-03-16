<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/person")
 */
class PersonController extends AbstractController
{
    /**
     * @Route("/", name="person_index", methods={"GET"})
     */
    public function index(PersonRepository $personRepository): Response
    {
        $persons = $personRepository->findAll();
        $result = array();
        if(!$persons){
            return $this->json($result, $status = 200, $headers = [], $context = []); 
        }
        foreach($persons as &$person) {
            $result[] = array(
                'id' => $person->getId(),
                'name' => $person->getName(),
                'lastName' => $person->getLastName(),
                'email' => $person->getEmail(),
                'ci' => $person->getCi()
            );
        }
        return $this->json($result, $status = 200, $headers = [], $context = []);
    }

    /**
     * @Route("/", name="person_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $ci = $data['ci'];
        if (empty($name) || empty($lastName) || empty($email) || empty($ci)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }
        $person = new Person();
        $person->setName($name);
        $person->setLastName($lastName);
        $person->setEmail($email);
        $person->setCi($ci);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($person);
        $entityManager->flush();
        return $this->json(['status' => 'Person created!'], $status = 200, $headers = [], $context = []);
    }

    /**
     * @Route("/{id}", name="person_show", methods={"GET"})
     */
    public function show(Person $person): Response
    {
        $result = array();
        if(!$person){
            return $this->json($result, $status = 200, $headers = [], $context = []); 
        }
        $result[] = array(
            'id' => $person->getId(),
            'name' => $person->getName(),
            'lastName' => $person->getLastName(),
            'email' => $person->getEmail(),
            'ci' => $person->getCi()
        );
        return $this->json($result, $status = 200, $headers = [], $context = []);
    }

    /**
     * @Route("/{id}", name="person_edit", methods={"PUT"})
     */
    public function edit(Request $request, Person $person): Response
    {
        if(!$person){
            return $this->json(['error' => 'There is not such a person'], $status = 500, $headers = [], $context = []); 
        }
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $ci = $data['ci'];
        $person->setName(empty($name) ? $person->getName() : $name);
        $person->setlastName(empty($lastName) ? $person->getLastName() : $lastName);
        $person->setEmail(empty($email) ? $person->getEmail() : $email);
        $person->setCi(empty($ci) ? $person->getCi() : $ci);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(['status' => 'Person updated!'], $status = 200, $headers = [], $context = []);
    }

    /**
     * @Route("/{id}", name="person_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Person $person): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($person);
        $entityManager->flush();
        return $this->json(array('message' => 'Person was deleted'), $status = 200, $headers = [], $context = []);
    }
}
