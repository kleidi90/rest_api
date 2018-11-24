<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Result;
use AppBundle\Entity\Job;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends FOSRestController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    //#### CREATE JOB ####

    /**
     * @post("/job/create", name="createJob")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postJobAction(Request $request) {

        $result = new Result();
        $job = new Job();
        $data = json_decode($request->getContent(),true);

        try {

            //Make a general check if all the fields are populated
            if ($this->checkData($data)){
                //Call the service if it exists
                $this->getService($data['serviceid']);

            }

            //Check if the date is ok and the format is correct
            $formatedDate = $this->checkDateFormat($data['executiondate']);

            //Check if the zipcode is a valid German zipcode
            if ( !(preg_match('/^\d{5}$/', $data['zipcode']) && (int) $data['zipcode'] > 1000 && (int) $data['zipcode'] < 99999) ) {
                throw $this->createNotFoundException('This zip code is not a valid German ZipCode: ' . $data['zipcode']);
            }

            $em = $this->getDoctrine()->getManager();

            //Prepare the object for the insertion
            $job->setTitle($data['title']);
            $job->setDescription($data['description']);
            $job->setExecutionDate($formatedDate);
            $job->setCity($data['city']);
            $job->setServiceId($data['serviceid']);
            $job->setZipcode($data['zipcode']);

            //Tells Doctrine we want to save the Job (no queries yet)
            $em->persist($job);

            //Executes the queries (INSERT query)
            $em->flush();

            //Set up the Success message
            $result->setSuccess(true);
            $result->setMessage('Job  \''.$job->getTitle().'\'  inserted!');
            $result->setItems( $job);

            //Set the result
            $view = $this->view($result);

            //Reutrn all
            return $this->handleView($view);


        } catch (BadRequestHttpException $e) {
            //Catch the response of a bad formed request
            $errorCode = "MHM-3";
            $logger = $this->get('logger');
            $logger->error('Code:400 Description:' . $e->getMessage());
            $result->setSuccess(false);
            $result->setMessage($e->getMessage());
            $result->setErrorCode($errorCode);
            $view = $this->view($result, 400);
            return $this->handleView($view);
        } catch (NotFoundHttpException $e) {
            //Catch the exeption if some inputs are not correct
            $errorCode = "MHM-84";
            $logger = $this->get('logger');
            $logger->error('Code:404 Description:' . $e->getMessage());
            $result->setSuccess(false);
            $result->setMessage($e->getMessage());
            $result->setErrorCode($errorCode);
            $view = $this->view($result, 404);
            return $this->handleView($view);
        } catch (\Exception $e) {
            //Catch the general error
            $errorCode = "MHM-1";
            $logger = $this->get('logger');
            $logger->error('Code:500 Description:' . $e->getMessage());
            $result->setSuccess(false);
            $time = new \DateTime("now");
            $result->setErrorCode($errorCode);
            $result->setMessage("General error " . $time->format("d-m-y") . ": " . $e->getMessage());
            $view = $this->view($result, 500);
            return $this->handleView($view);
        }
    }



    public function checkData(array $data){
        foreach($data as $key => $item) {
            if ($item == null){
                throw $this->createNotFoundException(ucfirst($key).' can\'t be empty!');
            }else{

//                if(strlen($data['title'])< 5 or strlen($data['title']) > 50){
//                    throw $this->createNotFoundException('The title should be between 5 and 50 characters: ' . $data['title']);
//
//                }
            }

        }

    }


    public function checkDateFormat($executiondate){

        $date  = new \DateTime;
        //Set the format I want the date
        $format = 'Y-m-d';
        $formatedDate = $date->createFromFormat($format, $executiondate);
        //Transfrom the date in the correct format
        $date_final = $formatedDate->format($format);

        if (!$formatedDate or $date_final != $executiondate){
            throw $this->createNotFoundException('This date is not correct: ' . $executiondate);
        }

        return $formatedDate;

    }

    public function getService ($serviceid){

            //Find the service in the database
            $repo = $this->getDoctrine()->getRepository('AppBundle:Service');
            $service = $repo->find($serviceid);

            //Check if the service enetered exists on the Services table
            if($service){
                return $service;
            }else{
                throw $this->createNotFoundException('The service enetered is not valid!');
            }

        }


}
