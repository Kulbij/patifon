function countrychange(base_url, id) {
    $('#subaddress_sub').html();
    $('#addressid').hide();
    $('#subcity_sub').html();
    $('#subcity').hide();
    $('#subcountry_sub').html();
    $('#subcountry').hide();
    $.ajax({
        url: base_url + 'countrychange',
        type: 'POST',
        data: "id=" + id,
        success: function(data) {
            if (data != 'error') {
                $('#subcountry_sub').html(data);
                $('#subcountry').show();
                $('#input_country').val(id);
                $('#input_country_new').val(id);
            }
        }
    });
    selectCity(base_url, id);
    return false;
}

function selectCity(base_url, countryid) {
    $.ajax({
        url: base_url + 'selectcity',
        type: 'POST',
        data: "country=" + countryid,
        success: function(data) {
            if (data != 'error') {
                $('#select_city').html(data);
                $('#cityid').show();
            }
        }
    });
    return false;
}

function changecity(base_url, id) {
    $('#subaddress_sub').html();
    $('#addressid').hide();
    $('#subcity_sub').html();
    $('#subcity').hide();
    $.ajax({
        url: base_url + 'citychange',
        type: 'POST',
        data: "id=" + id,
        success: function(data) {
            if (data != 'error') {
                $('#subcity_sub').html(data);
                $('#subcity').show();
                $('#input_city').val(id);
                $('#input_city_new').val(id);
            }
        }
    });
    selectAddress(base_url, id);
    return false;
}

function selectAddress(base_url, cityid) {
    $.ajax({
        url: base_url + 'selectaddress',
        type: 'POST',
        data: "city=" + cityid,
        success: function(data) {
            if (data != 'error') {
                $('#subaddress_sub').html(data);
                $('#addressid').show();
            }
        }
    });
    return false;
}

function addcountry() {
    $('#div_add_country').hide();
    $('#div_cal_country').show();
    $('#select_country').hide();
    $('#countrysave').hide();
    $('#countrysave_new').show();
    $('#subcountry').show();
}

function delcountry() {
    $('#div_cal_country').hide();
    $('#div_add_country').show();
    $('#select_country').show();
    $('#countrysave_new').hide();
    $('#countrysave').show();
    $('#subcountry').show();
}

function addcity() {
    $('#div_add_city').hide();
    $('#div_cal_city').show();
    $('#select_city').hide();
    $('#citysave').hide();
    $('#citysave_new').show();
    $('#subcity').show();
}

function delcity() {
    $('#div_cal_city').hide();
    $('#div_add_city').show();
    $('#select_city').show();
    $('#citysave_new').hide();
    $('#citysave').show();
    $('#subcity').show();
}

function addaddress() {
    $('#div_add_address').hide();
    $('#div_cal_address').show();
    $('#addresssave').hide();
    $('#addresssave_new').show();
    $('#subaddress').show();
}

function deladdress() {
    $('#div_cal_address').hide();
    $('#div_add_address').show();
    $('#addresssave_new').hide();
    $('#addresssave').show();
    $('#subaddress').show();
}