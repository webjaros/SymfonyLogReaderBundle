<?php

namespace WebJaros\SymfonyLogReaderBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class RecordAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_page' => 1, // Display the first page (default = 1)
        '_sort_order' => 'DESC', // Descendant ordering (default = 'ASC')
        '_sort_by' => 'createdAt' // name of the ordered field (default = the model id field, if any)
        // the '_sort_by' key can be of the form 'mySubModel.mySubSubModel.myField'.
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'createdAt',
                'doctrine_orm_date_range',
                [
                    'show_filter' => true,
                ],
                null,
                [
                    'field_options' => [
                        'format' => 'dd.MM.yy',
                        'widget' => 'single_text',
                        'attr' => [
                            'class' => 'datetimepicker',
                        ]
                    ]
                ]
            )
            ->add(
                'channel',
                null,
                [
                    'show_filter' => true,
                ]
            )
            ->add(
                'level',
                null,
                [
                    'show_filter' => true,
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('createdAt', 'datetime', ['format' => 'd.m.y H:i:s'])
            ->add('channel')
            ->add('level')
            ->add('message')
        ;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'export']);
    }
}