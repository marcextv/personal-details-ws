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
     * @Route("/new", name="person_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        printf($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($person);
            $entityManager->flush();

            return $this->redirectToRoute('person_index');
        }

        $result [] = array('error' => 'Invalid form');

        return $this->json($result, $status = 500, $headers = [], $context = []);
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
     * @Route("/{id}/edit", name="person_edit", methods={"POST"})
     */
    public function edit(Request $request, Person $person): Response
    {
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('person_index');
        }

        return $this->render('person/edit.html.twig', [
            'person' => $person,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="person_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Person $person): Response
    {
        if ($this->isCsrfTokenValid('delete'.$person->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($person);
            $entityManager->flush();
        }

        return $this->redirectToRoute('person_index');
    }
}
