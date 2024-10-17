




</div>
</div>
</div>
</div>
</div>

<!-- Javascripts -->
<script>
  window.watsonAssistantChatOptions = {
    integrationID: "4fc0dd8d-f1d5-470b-9d03-c3246df81676", // The ID of this integration.
    region: "us-east", // The region your integration is hosted in.
    serviceInstanceID: "9cd70f0d-1c84-46ca-9766-0b5c53752989", // The ID of your service instance.
    onLoad: async (instance) => { await instance.render(); }
  };
  setTimeout(function(){
    const t=document.createElement('script');
    t.src="https://web-chat.global.assistant.watson.appdomain.cloud/versions/" + (window.watsonAssistantChatOptions.clientVersion || 'latest') + "/WatsonAssistantChatEntry.js";
    document.head.appendChild(t);
  });
</script>
<script src="<?php echo BASE_URL . 'Assets/plugins/jquery/jquery-3.5.1.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/plugins/bootstrap/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/plugins/perfectscroll/perfect-scrollbar.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/plugins/pace/pace.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/plugins/apexcharts/apexcharts.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/js/main.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/js/sweetalert2@11.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/plugins/DataTables/datatables.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/js/tema.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/js/custom.js'; ?>"></script>
<script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
</script>
<script type="text/javascript">
   (function(){
      emailjs.init({
        publicKey: "LGf9qRCUmb-65UO0q",
      });
   })();
</script>
<!--<script src="<?php echo BASE_URL . 'Assets/js/pages/dashboard.js'; ?>"></script>-->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>


<script>
    const base_url = '<?php echo BASE_URL; ?>'
</script>
<?php if (!empty($data['script'])) { ?>
    <script src="<?php echo BASE_URL . 'Assets/js/pages/' . $data['script']; ?>"></script>
<?php } ?>
</body>


</body>

</html>
