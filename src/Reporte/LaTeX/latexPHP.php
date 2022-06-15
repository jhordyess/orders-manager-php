<?php

/**
 * Class for handling latex templating
 * 
 * @author Michael Billington < michael.billington@gmail.com >
 */
class LatexTemplate
{

  /**
   * Generate a PDF file using xelatex and pass it to the user
   */
  public static function download($data, $template_file, $outp_file, $imc)
  {
    //-- Pre-flight checks --/
    if (!file_exists($template_file)) {
      throw new Exception("Could not open template");
    }
    if (($f = tempnam(sys_get_temp_dir(), 'tex-')) === false) {
      throw new Exception("Failed to create temporary file");
    }
    $tex_f = $f . ".tex";
    $aux_f = $f . ".aux";
    $log_f = $f . ".log";
    $out_f = $f . ".out";
    $synctex_f = $f . ".synctex.gz";
    $pdf_f = $f . ".pdf";
    //-- Mejora para sustituir variable --/
    ob_start();
    include($template_file);
    file_put_contents($tex_f, ob_get_clean());

    $cmd = sprintf("pdflatex -synctex=1 -interaction=nonstopmode -halt-on-error %s", escapeshellarg($tex_f));
    chdir(sys_get_temp_dir());
    exec($cmd, $foo, $ret);
    //-- Limpieza de archivos auxiliares de latex --/
    @unlink($tex_f);
    @unlink($aux_f);
    @unlink($log_f);
    @unlink($out_f); //ficheros que se generan en mi version
    @unlink($synctex_f); // ibidem
    //-- Prueba de existencia --/
    if (!file_exists($pdf_f)) {
      @unlink($f);
      if ($imc != "") {
        @unlink($imc);
      }
      throw new Exception("Output was not generated and latex returned: $ret.");
    }
    //-- Obtener y descargar --/
    /* $fp = fopen($pdf_f, 'rb');
      header('Content-Type: application/pdf');
      header('Content-Disposition: attachment; filename="' . $outp_file . '"');
      header('Content-Length: ' . filesize($pdf_f));
      fpassthru($fp); */
    //-- Mostrar en pantalla///
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $outp_file . '"');
    header('Content-Length: ' . filesize($pdf_f));
    //** X si se tarda en compilar(aunque no tiene tiempo de espera) --/
    do {
      if (file_exists($pdf_f)) {
        @readfile($pdf_f);
        break;
      }
    } while (true);
    //-- Limpieza final///
    @unlink($pdf_f);
    @unlink($f);
    if ($imc != "") {
      @unlink($imc);
    }
  }

  /**
   * Series of substitutions to sanitise text for use in LaTeX.
   *
   * http://stackoverflow.com/questions/2627135/how-do-i-sanitize-latex-input
   * Target document should \usepackage{textcomp}
   */
  public static function escape($text)
  {
    // Prepare backslash/newline handling
    /* $text = str_replace("\n", "\\\\", $text); // Rescue newlines
      $text = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $text); // Strip all non-printables
      $text = str_replace("\\\\", "\n", $text); // Re-insert newlines and clear \\
      $text = str_replace("\\", "\\\\", $text); // Use double-backslash to signal a backslash in the input (escaped in the final step).
      // Symbols which are used in LaTeX syntax
      $text = str_replace("{", "\\{", $text);
      $text = str_replace("}", "\\}", $text);
      $text = str_replace("$", "\\$", $text);
      $text = str_replace("&", "\\&", $text);
      $text = str_replace("#", "\\#", $text);
      $text = str_replace("^", "\\textasciicircum{}", $text);
      $text = str_replace("_", "\\_", $text);
      $text = str_replace("~", "\\textasciitilde{}", $text);
      $text = str_replace("%", "\\%", $text);

      // Brackets & pipes
      $text = str_replace("<", "\\textless{}", $text);
      $text = str_replace(">", "\\textgreater{}", $text);
      $text = str_replace("|", "\\textbar{}", $text);

      // Quotes
      $text = str_replace("\"", "\\textquotedbl{}", $text);
      $text = str_replace("'", "\\textquotesingle{}", $text);
      $text = str_replace("`", "\\textasciigrave{}", $text);

      // Clean up backslashes from before
      $text = str_replace("\\\\", "\\textbackslash{}", $text); // Substitute backslashes from first step.
      $text = str_replace("\n", "\\\\", trim($text)); // Replace newlines (trim is in case of leading \\) */
    return $text;
  }
}
