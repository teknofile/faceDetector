{combine_css path=$FACEDETECTOR_PATH|@cat:"admin/template/style.css"}

<h2>{$TITLE} &#8250; {'Edit photo'|translate} {$TABSHEET_TITLE}</h2>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@recogito/annotorious@2.5.2/dist/annotorious.min.css">
<script src="https://cdn.jsdelivr.net/npm/@recogito/annotorious@2.5.2/dist/annotorious.min.js"></script>


<form action="{$F_ACTION}" method="post" id="catModify">
  <fieldset>
    <input type="hidden" name="detect_faces" id="detect_faces" value="true" />
    <table width="90%" border="1">
    <tr>
      <td align="center" width="50%">
        <legend>{'Detect faces within this photo.'|translate}</legend>
      </td>
      <td align="center">
        <legend>{'Detected faces'|translate}</legend>
    </tr>
    <tr>
      <td align="center" width="50%">
      <p>
        <div align="center">{$DEBUG_MSG}</div>
        <div id="toolbar"></div>
        <div align="center"> 
          <img id="faceDetectorImg" src="{$SRC_IMG}" alt="{'Image Source'|translate}">
        </div>
        <style>
          #toolbar {
            padding-bottom: 10px;
          }

          @media only screen and (max-width: 800px) {
            .r6o-editor {
              width:260px !important;
            }
          }
        </style>
        <script>
          var sampleAnnotation = { 
            "@context": "http://www.w3.org/ns/anno.jsonld",
            "id": "#a88b22d0-6106-4872-9435-c78b5e89fede",
            "type": "Annotation",
            "body": [{
              "type": "TextualBody",
              "value": "It's Hallstatt in Upper Austria"
            }, {
              "type": "TextualBody",
              "purpose": "tagging",
              "value": "Hallstatt"
            }, {
              "type": "TextualBody",
              "purpose": "tagging",
              "value": "Upper Austria"
            }],
            "target": {
              "selector": {
                "type": "FragmentSelector",
                "conformsTo": "http://www.w3.org/TR/media-frags/",
                "value": "xywh=pixel:421,80,151,151"
              }
            }
          };

          window.onload = function() {
            var anno = Annotorious.init({
              image: 'faceDetectorImg',
              locale: 'auto',
              allowEmpty: true
            });

            Annotorious.Toolbar(anno, document.getElementById('toolbnar'));
            anno.addAnnotation(sampleAnnotation);
          }
        </script>
      </p>
      </td>
      <td align="center">
        <div align="center">
          <img src="" alt="{'Picture with boxes in it'|translate}">
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <p>
          <input class="submit" type="submit" value="{'Detect Faces'|translate}" name="save_faceDetector">
        </p>
      </td>
    </tr>
    </table>
  </fieldset>
</form>