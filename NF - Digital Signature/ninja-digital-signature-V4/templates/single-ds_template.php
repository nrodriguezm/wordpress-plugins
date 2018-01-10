<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
use Dompdf\Dompdf;
include_once(PLUGIN_DIR . "templates/pdf_templates/ds_template.php");

 ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
			<?php
			while ( have_posts() ) : the_post();
				$dompdf = new Dompdf();
				$dompdf->set_option( 'isRemoteEnabled', TRUE );
				$dompdf->set_option('isHtml5ParserEnabled', true);
				
				$args['fields'] = $field_values;
				$args['id_template'] = get_the_ID();
				
				$args['autoincrement'] = '';
				$args['settings'] = ''; 
				
				$html = apply_filters( "ds_register_template", $args );
				
				$dompdf->loadHtml($html);

				//Setup the paper size and orientation
				$dompdf->setPaper('A4');

				//Render the HTML as PDF
				$dompdf->render();

				// Output the generated PDF to Browser
				$file = $dompdf->output();
				
				$datetime = strtotime("now");
				$pdf_name = "digital_signature_nuevo_$datetime.pdf";
				
				file_put_contents(UPLOAD_DIR . "/$pdf_name", $file);
		
				$pdf_url = get_site_url() . "/wp-content/uploads/ds_uploads/$pdf_name"; 
			
				?>
				<div style="text-align:center;">
					<object data="<?php echo $pdf_url; ?>" type="application/pdf" width="100%" height="900">
						alt : <a href="<?php echo $pdf_url; ?>">test.pdf</a>
					</object>
				</div>
				<?php
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

