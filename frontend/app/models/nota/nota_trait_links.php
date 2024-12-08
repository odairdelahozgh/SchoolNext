<?php
trait NotaTraitLinks 
{

  public static function lnkCuadroHonorPrimariaPDF(int $periodo): string 
  {
    try
    {
      return OdaTags::linkButton
      (
        action: "admin/notas/exportCuadroHonorPrimariaPdf/$periodo", 
        text: "Top 10 - P$periodo",      
        attrs: 'class="w3-button w3-green" target="_blank"',
      );
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
      return '';
    }
  }
  
  
  public static function lnkCuadroHonorBachilleratoPDF(int $periodo): string 
  {
    try
    {
      return OdaTags::linkButton
      (
        action: "admin/notas/exportCuadroHonorBachilleratoPdf/$periodo", 
        text: "Top 10 - P$periodo",
        attrs: 'class="w3-button w3-green" target="_blank"',
      );
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
      return '';
    }
  }    

  
  public static function lnkCuadroHonorGeneralPrimariaPDF(int $periodo): string 
  {
    try
    {
      return OdaTags::linkButton
      (
        action: "admin/notas/exportCuadroHonorGeneralPrimariaPdf/$periodo", 
        text: "Puestos P$periodo",      
        attrs: 'class="w3-button w3-blue" target="_blank"',
      );
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return '';
    }
  }
  
  
  public static function lnkCuadroHonorGeneralBachilleratoPDF(int $periodo): string 
  {
    try
    {
      return OdaTags::linkButton
      (
        action: "admin/notas/exportCuadroHonorGeneralBachilleratoPdf/$periodo", 
        text: "Puestos P$periodo",
        attrs: 'class="w3-button w3-blue" target="_blank"',
      );
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return '';
    }
  }


  
  public static function lnkPageCalificar(int $periodo_id, int $salon_id, int $asignatura_id, $enabled=true): string 
  {
    try
    {
      if (!$enabled)
      {
        return '';
      }
      return OdaTags::linkButton
      (
        action: "docentes/notasCalificar/{$periodo_id}/{$salon_id}/{$asignatura_id}", 
        text: "Calificar <br>P{$periodo_id}", 
        icon: '', 
        attrs: 'title="Ingresar NOTAS" class="w3-button w3-small w3-pale-green w3-round-large"',
      );
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return '';
    }
  }


  public static function lnkPageSeguimientos(int $periodo_id, int $salon_id, int $asignatura_id, $enabled=true): string 
  {
    try
    {
      if (!$enabled)
      {
        return '';
      }
      return OdaTags::linkButton
      (
        action: "docentes/notasCalificarSeguimientos/{$periodo_id}/{$salon_id}/{$asignatura_id}", 
        text: "Seguimientos <br>Intermedios P{$periodo_id}", 
        icon: '', 
        attrs: 'title="Ingresar SEGUIMIENTOS INTERMEDIOS" class="w3-button w3-small w3-pale-blue w3-round-large"'
      );
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
      return '';
    }
  }


  public static function lnkPagePlanesApoyo(int $periodo_id, int $salon_id, int $asignatura_id, $enabled=true): string 
  {
    try 
    {
      if (!$enabled)
      {
        return '';
      }
      return OdaTags::linkButton
      (
        action: "docentes/notasCalificarPlanesApoyo/{$periodo_id}/{$salon_id}/{$asignatura_id}", 
        text: "Planes de <br>Apoyo P{$periodo_id}", 
        icon: '', 
        attrs: 'title="Ingresar PLANES DE APOYO" class="w3-button w3-small w3-pale-red w3-round-large"'
      );
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
      return '';
    }
  }


}