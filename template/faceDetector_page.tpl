{* <!-- load CSS files --> *}
{combine_css id="faceDetector" path=$FACEDETECTOR_PATH|cat:"template/style.css"}

{* <!-- load JS files --> *}
{* {combine_script id="faceDetector" require="jquery" path=$FACEDETECTOR_PATH|cat:"template/script.js"} *}

{* <!-- add inline JS --> *}
{footer_script require="jquery"}
  jQuery('#faceDetector').on('click', function(){
    alert('{'Hello world!'|translate}');
  });
{/footer_script}

{* <!-- add inline CSS --> *}
{html_style}
  #faceDetector {
    display:block;
  }
{/html_style}


{* <!-- add page content here --> *}
<h1>{'What faceDetector can do for me?'|translate}</h1>

<blockquote>
  {$INTRO_CONTENT}
</blockquote>

<div id="faceDetector">{'Click for fun'|translate}</div>
