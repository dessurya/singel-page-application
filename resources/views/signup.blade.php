<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Signup Area</title>

    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('_css/custom.min.css') }}" rel="stylesheet">
    <style type="text/css">
      #boxOne{
        position: relative; margin: 20px auto; width: 65%;
      }
      ul#myTab li{
        pointer-events: none;
      }
      #info_alert{
        width: 75%;
        margin: 0 auto;
        display: none;
      }
      @media (max-width: 812px) {
        #boxOne{
          margin: 20px auto; width: 95%;
        }
      }
    </style>
  </head>

  <body class="login">
    <div>
      {{ csrf_field() }}
      <div id="boxOne">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Signup <small>Area</small></h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  <li role="presentation" class="personal_tab active">
                    <a href="#">Personal</a>
                  </li>
                  <li role="presentation" class="experience_tab">
                    <a href="#">Experience</a>
                  </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="personal_tab" aria-labelledby="personal_tab">
                  <form id="formOne">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        Name
                        <p class="name error"></p>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input 
                          name="name" 
                          type="text" 
                          class="form-control col-md-7 col-xs-12"
                          required 
                          value=""
                        >
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        Date Of Birth
                        <p class="date_of_birth error"></p>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input 
                          name="date_of_birth" 
                          type="date" 
                          class="form-control col-md-7 col-xs-12"
                          required 
                          value="1970-12-31"
                        >
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">
                        Email
                        <p class="email error"></p>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input 
                          name="email" 
                          type="email" 
                          class="form-control col-md-7 col-xs-12"
                          required 
                          value=""
                        >
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="handphone">
                        Handphone
                        <p class="handphone error"></p>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input 
                          name="handphone" 
                          type="text" 
                          class="form-control col-md-7 col-xs-12"
                          required 
                          value=""
                        >
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gender">
                        Gender
                        <p class="gender error"></p>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <div id="gender2" class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default">
                            <input type="radio" name="gender" value="male"> &nbsp; Male &nbsp;
                          </label>
                          <label class="btn btn-primary">
                            <input type="radio" name="gender" value="female" checked=""> Female
                          </label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="religion">
                        Religion
                        <p class="religion error"></p>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <select
                          name="religion" 
                          type="text" 
                          class="form-control col-md-7 col-xs-12"
                          required
                        >
                          @foreach($master['religion'] as $row)
                          <option value="{{$row->value}}">{{$row->value}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="marital_status">
                        Marital Status
                        <p class="marital_status error"></p>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <select
                          name="marital_status" 
                          type="text" 
                          class="form-control col-md-7 col-xs-12"
                          required 
                        >
                          @foreach($master['marital'] as $row)
                          <option value="{{$row->value}}">{{$row->value}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="education">
                        Education
                        <p class="education error"></p>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <select
                          name="education" 
                          type="text" 
                          class="form-control col-md-7 col-xs-12"
                          required
                        >
                          @foreach($master['education'] as $row)
                          <option value="{{$row->value}}">{{$row->value}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="ln_solid"></div>
                    <div style="float: right;">
                      <button class="btn btn-success activeLI" data-href="#experience_tab">Next</button>
                    </div>
                  </form>
                  </div>
                  
                  <div role="tabpanel" class="tab-pane fade" id="experience_tab" aria-labelledby="experience_tab">
                    <form id="formTwo">
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="project_code">
                            Project Code
                            <p class="project_code error"></p>
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input 
                              name="project_code" 
                              type="text" 
                              class="form-control col-md-7 col-xs-12"
                              required 
                              value=""
                            >
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="project_name">
                            Project Name
                            <p class="project_name error"></p>
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input 
                              name="project_name" 
                              type="text" 
                              class="form-control col-md-7 col-xs-12"
                              required 
                              value=""
                            >
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="group_cos">
                            Group Co's
                            <p class="group_cos error"></p>
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input 
                              name="group_cos" 
                              type="text" 
                              class="form-control col-md-7 col-xs-12"
                              required 
                              value=""
                            >
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="current_companies">
                            Current Companies
                            <p class="current_companies error"></p>
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input 
                              name="current_companies" 
                              type="text" 
                              class="form-control col-md-7 col-xs-12"
                              required 
                              value=""
                            >
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="industry">
                            Industry
                            <p class="industry error"></p>
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select
                              name="industry" 
                              type="text" 
                              class="form-control col-md-7 col-xs-12"
                              required 
                            >
                              @foreach($master['industry'] as $row)
                              <option value="{{$row->value}}">{{$row->value}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="work_title">
                            Work Title
                            <p class="work_title error"></p>
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input 
                              name="work_title" 
                              type="text" 
                              class="form-control col-md-7 col-xs-12"
                              required 
                              value=""
                            >
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="level">
                            Level
                            <p class="level error"></p>
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select
                              name="level" 
                              type="text" 
                              class="form-control col-md-7 col-xs-12"
                              required
                            >
                              @foreach($master['level'] as $row)
                              <option value="{{$row->value}}">{{$row->value}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="competencies">
                            Competencies
                            <p class="competencies error"></p>
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select
                              name="competencies" 
                              type="text" 
                              class="form-control col-md-7 col-xs-12"
                              required
                            >
                              @foreach($master['competencies'] as $row)
                              <option value="{{$row->value}}">{{$row->value}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="ln_solid"></div>
                        <div id="button_send">
                          <div style="float: left;">
                            <a class="btn btn-default activeLI"  data-href="#personal_tab">Back</a>
                          </div>
                          <div style="float: right;">
                            <button class="btn btn-success" type="submit">Save</button>
                          </div>
                        </div>
                        <div id="info_alert" class="alert alert-info" role="alert"></div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>

    </div>
    <script type="text/javascript" src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('_js/custom.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
    <script type="text/javascript">
      
      $('form#formOne').submit(function(){
        var arr1 = getValueForm(['form#formOne input','form#formOne select']);
        sessionStorage.setItem("personal_data", JSON.stringify(arr1));
        return false;
      });

      $('form#formTwo').submit(function(){
        var personal_data = sessionStorage.getItem("personal_data");
        var experience_data = getValueForm(['form#formTwo input','form#formTwo select']);
        var data = { 
          'personal_data' : JSON.parse(personal_data), 
          'experience_data' : experience_data 
        };
        postData(data,'{{ route('auth.signup.action') }}');
        return false;
      });

      $('.activeLI').click(function(){
        var ok = true;
        if ($(this).data('href') == '#experience_tab') {
          $('#myTabContent #personal_tab input').each(function(){
            var thisVal = $(this).val();
            if (thisVal.length === 0) {
              ok = false; return false;
            }
          });
        }
        if (ok === true) { toggleTab(); }
      });
      

      function toggleTab() {
        $('ul#myTab li').toggleClass('active');
        $('#myTabContent .tab-pane').toggleClass('active');
        $('#myTabContent .tab-pane').toggleClass('in');
      }

      function getValueForm(selector) {
        var array = {};
        $(selector).each(function( key, val ){
          $(val).each(function(){
            var thisNam = $(this).attr('name');
            var thisVal = $(this).val();
            array[thisNam] = thisVal;
          });
        });
        return array;
      }

      function postData(data,url) {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url: url,
              type: 'post',
              dataType: 'json',
              data: data,
              beforeSend: function() {
                  $('#button_send').hide();
                  $('#info_alert').show().html('Waiting...! Send Your Request...!');
              },
              success: function(data) {
                console.log(data);
                if (data.Success == true) {
                  sessionStorage.removeItem("personal_data");
                  window.location.replace("{{ route('auth.login.token') }}?rememberMe="+data.user.remember_token);
                }
                window.setTimeout(function() {
                  $('#info_alert').hide();
                  $('#button_send').show();
                }, 1550);

              }
          });
      }
    </script>
    <script type="text/javascript" src="{{ asset('_js/gender2.js') }}"></script>
  </body>
</html>
