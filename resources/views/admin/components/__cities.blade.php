<script>
    $(document).ready(function(){
        $(document).on('click', '.country', function (e){
            e.preventDefault();

            let country_id = $(this).val();
            let url = "{{ route('admin.global.get-city', ':id') }}";

            url = url.replace(":id", country_id);

            $.ajax({
                type: "GET",
                url:  url,
                success: function (res){
                    if(res.data.status === true){
                        optionCity(res.data.data);
                    }
                }
            });
        });
    });

    function optionCity(datas){
        var $options = '';
        $.each(datas, function (index, data){
            $options += `<option value="${data.id}">${data.name}</option>`;
        });
        $('.city').html($options);
    }
</script>
