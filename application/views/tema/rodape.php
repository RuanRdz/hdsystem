<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

<script src="<?= base_url() ?>assets/js/matrix.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.multiselect.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.multiselect.filter.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.livequery.js"></script>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        var dataTableEnabled = '<?php echo $configuration['control_datatable']; ?>';
        if(dataTableEnabled == '1') {
            $('#tabela').dataTable( {
                "ordering": false,
                "language": {
                    "url": "<?= base_url(); ?>assets/js/dataTable_pt-br.json"
                }
            } );
        }
    } );
</script>
</html>
