<?php

namespace App\Controller;

use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    /**
     * @Route("/upload", methods={"GET"})
     */
    public function upload()
    {
        return $this->render("file/upload.html.twig");
    }
    /**
     * @Route("/upload", methods = {"POST"}, name="upload-file")
     */
    public function doUpload(Request $request, FileUploader $uploader)
    {
        $file = $request->files->get('pdf');
        $fname = $uploader->upload($file);
        if ($fname) {
            return $this->render("file/upload.html.twig", ["msg" => 'success', 'file' => $fname]);
        } else {
            return $this->render("file/upload.html.twig", ["msg" => 'unable to upload']);
        }
        // if ($file) {
        //     $fname = uniqid() . '.' . $file->guessExtension();
        //     try {
        //         $file->move($this->getParameter("upload-dir"), $fname);
        //     } catch (FileException $e) {
        //         return $this->render("file/upload.html.twig", ["msg" => 'unable to upload']);
        //     }
        //     return $this->render("file/upload.html.twig", ["msg" => 'success', 'file' => $fname]);
        // }
        return $this->render("file/upload.html.twig", ["msg" => "File not found" ]);
    }
}
