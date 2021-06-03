<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(Request $request): Response
    {
        dump($request);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * To generate simple form.
     *
     * @Route("/form", name="app_form")
     *
     * @return void
     */
    public function simpleForm(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('Title', TextType::class, [
                'attr' => ['class' => 'samp'],
            ])
            ->add('body', TextareaType::class)
            ->add('Email', EmailType::class)
            ->add('Height', IntegerType::class)
            ->add('Salary', MoneyType::class, ["currency" => "INR", "grouping" => true])
            ->add('ID_No', NumberType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                "invalid_message" => "The passwords should match",
                "options" => [ "attr" => ["class" => 'password-field']],
                "first_options" => ["label" => "Password"],
                "second_options" => ["label" => "Confirm password"]
            ])
            ->add('Percentage', PercentType::class)
            ->add("Blog", UrlType::class)
            ->add("Range", RangeType::class, [
                "attr" => [ "min" => 5, "max" => 25 ]
            ])
            // ->add("Tele_Nos", CollectionType::class, [
            //     "entry_type" => TelType::class,
            //     "entry_options" => [ 'attr' => ["class" => "tele-no"]],
            //     // "allow_add" => true,
            //     // "allow_delete" => true
            // ])
            ->add("Gener", ChoiceType::class, [
                "choices" => [
                    "Male" => 1,
                    "Female" => 2,
                    "Not to Say" => 0
                ]
            ])
            ->add('publishedAt', DateType::class, [
                'widget' => 'choice',
            ])
            ->add('EventDuaration', DateIntervalType::class, [
                'widget'      => 'integer',
                'with_years'  => false,
                'with_months' => false,
                'with_days'   => true,
                'with_hours'  => true,
            ])
            ->add("color", ColorType::class)
            ->add('birthdate', BirthdayType::class, [
                'placeholder' => 'Select a value',
            ])
            ->add("Confirm", RadioType::class, [
            ])
            ->add('reset', ButtonType::class, [
                'attr' => ['class' => 'button'],
            ])
            ->add('save', ResetType::class, [
                'attr' => ['class' => 'save'],
            ])
            ->add('stockStatus', ChoiceType::class, [
                'choices' => [
                    'Main Statuses' => [
                        'Yes' => 'stock_yes',
                        'No' => 'stock_no',
                    ],
                    'Out of Stock Statuses' => [
                        'Backordered' => 'stock_backordered',
                        'Discontinued' => 'stock_discontinued',
                    ],
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'submit'],
            ])
            ->getForm();
        return $this->render("main\\form.html.twig", ['form' => $form->createView()]);
    }
}
