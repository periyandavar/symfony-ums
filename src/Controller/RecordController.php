<?php

namespace App\Controller;

use App\Entity\Record;
use App\Repository\RecordRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/record")
 */
class RecordController extends AbstractController
{
    /**
     * @Route("/", name="all_records", methods = {"POST"})
     */
    public function insert(Request $request): Response
    {
        $record = new Record();
        $response = ['error' => false, 'result' => ''];
        $data = json_decode($request->getContent(), true);
        if (null !== $data) {
            $request->request->replace($data);
        }
        if (!$request) {
            return $this->json(['message' => 'Please provide a valid request!']);
        }
        $em = $this->getDoctrine()->getManager();
        $record->setFname($request->get('fname'));
        $record->setLname($request->get('lname'));
        $record->setDescription($request->get('description'));
        $em->persist($record);
        try {
            $em->flush();
            $response['result'] = 'Success..! Record inserted successfully..!';
        } catch (ORMException $e) {
            $response['error'] = true;
            $response['result'] = 'Failed to insert the record please try again later';
        }

        return $this->json($response);
    }

    /**
     * @Route("/", name="new_record", methods={"GET"})
     */
    public function index(RecordRepository $recordRepository): Response
    {
        return $this->json($recordRepository->findActive());
    }

    /**
     * Record details.
     *
     * @Route("/{id}", name="view_record", methods={"GET"})
     */
    public function view(Record $record): Response
    {
        return $this->json($record);
    }

    /**
     * Record details.
     *
     * @Route("/{id}", name="delete_record", methods={"DELETE"})
     */
    public function delete(Record $record): Response
    {
        $response = ['error' => false, 'result' => ''];
        $em = $this->getDoctrine()->getManager();
        $record->setIsDeleted(true);
        $em->persist($record);
        try {
            $em->flush();
            $response['result'] = 'Success..! Record deleted successfully..!';
        } catch (ORMException $e) {
            $response['error'] = true;
            $response['result'] = 'Failed to delete the record please try again later';
        }

        return $this->json($response);
    }

    /**
     * Update the record details.
     *
     * @Route("/{id}", name="update_record", methods={"PUT"})
     */
    public function update(Request $request, RecordRepository $recordRepository): Response
    {
        $response = ['error' => false, 'result' => ''];
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent());
        $record = $recordRepository->find($data->id);
        $record->setLname($data->lname);
        $record->setFName($data->fname);
        $record->setDescription($data->description);
        $em->persist($record);
        try {
            $em->flush();
            $response['result'] = 'Success..! Record updated successfully..!';
        } catch (ORMException $e) {
            $response['error'] = true;
            $response['result'] = 'Failed to update the record please try again later';
        }

        return $this->json($response);
    }
}
