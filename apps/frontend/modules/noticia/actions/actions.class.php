<?php

/**
 * noticia actions.
 *
 * @package    sf2013
 * @subpackage noticia
 * @author     Javi
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class noticiaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->noticias = Doctrine_Core::getTable('Noticia')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new NoticiaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new NoticiaForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($noticia = Doctrine_Core::getTable('Noticia')->find(array($request->getParameter('id'))), sprintf('Object noticia does not exist (%s).', $request->getParameter('id')));
    $this->form = new NoticiaForm($noticia);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($noticia = Doctrine_Core::getTable('Noticia')->find(array($request->getParameter('id'))), sprintf('Object noticia does not exist (%s).', $request->getParameter('id')));
    $this->form = new NoticiaForm($noticia);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($noticia = Doctrine_Core::getTable('Noticia')->find(array($request->getParameter('id'))), sprintf('Object noticia does not exist (%s).', $request->getParameter('id')));
    $noticia->delete();

    $this->redirect('noticia/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $noticia = $form->save();

      $this->redirect('noticia/edit?id='.$noticia->getId());
    }
  }
}
