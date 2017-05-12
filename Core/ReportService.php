<?php

namespace DmitryTrish\ReportBundle\Core;

use DmitryTrish\ReportBundle\Core\Exception\FailPersistException;
use DmitryTrish\ReportBundle\Core\Exception\NullRequestException;
use DmitryTrish\ReportBundle\Entity\Report;
use DmitryTrish\ReportBundle\Form\ReportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\RequestStack;

class ReportService
{
    protected $em;
    protected $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->em = $entityManager;
        $this->requestStack = $requestStack;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @return RequestStack
     */
    public function getRequestStack()
    {
        return $this->requestStack;
    }

    /**
     * Creating report form.
     *
     * @return FormInterface
     */
    public function createForm()
    {
        $factory = Forms::createFormFactory();
        $form = $factory->create(ReportType::class);
        $form->handleRequest();

        return $form;
    }

    /**
     * Register report.
     *
     * @param Report $report
     *
     * @throws NullRequestException
     * @throws FailPersistException
     *
     * @return Report
     */
    public function register(Report $report)
    {
        $request = $this->getRequestStack()->getMasterRequest();

        if (null === $request) {
            throw new NullRequestException();
        }

        $report
            ->setCreatedAt(new \DateTime())
            ->setIpAddress($request->getClientIp())
            ->setUserAgent($request->headers->get('User-Agent'))
            ->setUrl($request->getUri());

        try {
            $this->em->persist($report);
            $this->em->flush();
        } catch (\Exception $e) {
            throw new FailPersistException($e->getMessage());
        }

        return $report;
    }

    /**
     * Delete report.
     *
     * @param Report $report
     *
     * @return bool
     */
    public function delete(Report $report)
    {
        try {
            $this->em->remove($report);
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}