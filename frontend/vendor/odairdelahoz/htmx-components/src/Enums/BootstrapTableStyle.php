<?php

namespace HtmxComponents\Enums;

enum BootstrapGeneralStyle: string
{
  Use EnumsFunciones;
    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case SUCCESS = 'success';
    case DANGER = 'danger';
    case WARNING = 'warning';
    case INFO = 'info';
    case LIGHT = 'light';
    case DARK = 'dark';

    case LINK = 'link';
    
    case TABLE = 'table';
    case TABLE_PRIMARY = 'table-primary';
    case TABLE_SECONDARY = 'table-secondary';
    case TABLE_SUCCESS = 'table-success';
    case TABLE_DANGER = 'table-danger';
    case TABLE_WARNING = 'table-warning';
    case TABLE_INFO = 'table-info';
    case TABLE_LIGHT = 'table-light';
    case TABLE_DARK = 'table-dark';
    
    case TABLE_RESPONSIVE = 'table-responsive';
    case TABLE_RESPONSIVE_SM = 'table-responsive-sm';
    case TABLE_RESPONSIVE_MD = 'table-responsive-md';
    case TABLE_RESPONSIVE_LG = 'table-responsive-lg';
    case TABLE_RESPONSIVE_XL = 'table-responsive-xl';
    case TABLE_RESPONSIVE_XXL = 'table-responsive-xxl';


    case TABLE_BOTTOM = 'table-bottom';
    case TABLE_STRIPPED = 'table-striped';
    case TABLE_STRIPPED_COLUMNS = 'table-striped-columns';
    case TABLE_HOVER = 'table-hover';
    case TABLE_ACTIVE = 'table-active';
    
    case TABLE_BORDERED = 'table-bordered';
    case TABLE_BORDERLESS = 'table-borderless';
    case TABLE_SM = 'table-sm';
    case TABLE_GROUPDIVIDER = 'table-group-divider';
    

    case ALIGN_MIDDLE = 'align-middle';
    case ALIGN_BOTTOM = 'align-bottom';
    case ALIGN_TOP = 'align-top';
    
}