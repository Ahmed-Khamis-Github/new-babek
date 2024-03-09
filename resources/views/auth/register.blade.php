<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="auto">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset("frontend/assets/img/babak.png")}}" type="image/png">
    <title>{{ config('app.name') }} | {{ __('Register') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- External CSS libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.4/vue.js'></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!-- RTL and LTR styles (commented out) -->
    {{-- @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale()=='ar')
    <style>
      body{
        direction: ltr;
      }
      input{
        text-align: right;
      }
      .wizardform{
        text-align: right;
      }
      #country{
        text-align: right;
      }
    </style>
    @else
    <style>
      body{
        direction: rtl;
      }
      input{
        text-align: left;
      }
    </style>
    @endif --}}
    <!-- Styles -->

    
    <style>
        .iti__country-list .iti__country {
    color: red; /* Change to your desired text color */
}

/* Customize the text color of the selected country */
.iti__country.active {
    color: red; /* Change to your desired text color */
}

/* Customize the text color of the search input placeholder */
.iti__country-list-search input::placeholder {
    color: red; /* Change to your desired text color */
}
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/register.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.3/build/css/intlTelInput.css">

</head>
<body>
    <!-- Video background -->
    <div class="video-bg">
      <video width="320" height="240" autoplay loop muted>
        <source
          src={{ asset('frontend/assets/img/vid6.mp4')}}
          type="video/mp4"
        />
        Your browser does not support the video tag.
      </video>
    </div>
    <!-- Main content container -->
<div class="container mx-0 mw-100">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5 ">
            <!-- Registration form card -->
            <div class="card mt-5 mb-3 p-4 content">
                <form method="POST" class="wizardform" action="{{ route('register_user') }}" >
                    @csrf
                    <div class="container">
                        <div id="app">
                            <!-- Vue.js dynamic step navigation -->
                            <step-navigation :steps="steps" :currentstep="currentstep">
                            </step-navigation>
                            <!-- Vue.js dynamic form steps -->
                            <div v-show="currentstep == 1">
                                 <!-- Personal information form fields -->
                                <div class="form-group ">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input id="name" onkeyup="laststep()" type="text" required class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div id="nameError"> </div>

                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input id="email" onkeyup="laststep()" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    <small id="email" class="form-text text-muted">{{ __("We'll never share your email with anyone else.") }}</small>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div id="emailError"> </div>

                                </div>
                                <div class="form-group">
                                    <label for="phone">{{ __('Phone Number') }}</label>
                                    <input id="phone" onkeyup="laststep()" type="phone" class="form-control" name="phone" value="{{ old('phone') }}" required autocomplete="">
                                    <div id="phoneError"> </div>
                                    <input type="hidden" name="dial_code" id="dial_code" value="">

                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" onkeyup="laststep()" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div id="passwordError"> </div>

                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" onkeyup="laststep()" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    <div class="error"></div>
                                    <div id="confirmError"> </div>

                                </div>

                            </div>

                            <div v-show="currentstep == 2">
                                 <!-- Company information form fields -->
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="country">{{ __('Where do you want to establish the company') }}</label>
                                        {{-- <input id="country" onkeyup="laststep()" type="text" class="form-control " name="country" value="{{ old('country') }}" required autocomplete="city" autofocus> --}}
                                        <select class="form-control form-control-lg" name="country" id="country" value="{{ old('country') }}" required autocomplete="city" autofocus >
                                            @foreach ($countries as $country)
                                            <option id="{{ $country->name }}" value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <div id="CountryError"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company">{{ __('Company Suggested Name')}}</label>
                                        <input id="company" onkeyup="laststep()" type="text" class="form-control " name="company" value="{{ old('company') }}" required autocomplete="Company" autofocus>
                                        <div id="CompanyNameError"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="partners">{{ __('Number of partners') }}</label>
                                        <input id="partners" type="number" class="form-control "onkeyup="addFields()" name="partners" value="{{ old('partners') }}" required autocomplete="partners" autofocus>
                                        <div id="PartnersError"> </div>

                                        {{-- <a href="#" id="filldetails" onclick="addFields()">Fill Details</a> --}}
                                    </div>
                                    <div id="container">

                                    </div>
                                    <div class="form-group">
                                        <label for="regesterd">{{ __('Is the company already registered in another country?') }}</label>
                                        <br>
                                        <input type="radio" id="Yes" onkeyup="laststep()" name="regesterd"  value="Yes" @if(old('regesterd')) checked @endif>
                                        <label for="Yes">{{ __('Yes') }}</label>
                                        <input type="radio" id="No" onkeyup="laststep()" name="regesterd" value="No" @if(old('regesterd')) checked @endif>
                                        <label for="No">{{ __('No') }}</label><br>
                                        <div id="RegesterdErorr"> </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="capital">{{ __('Capital') }}</label>
                                        <input id="capital" onkeyup="laststep()" type="text" class="form-control " name="capital" value="{{ old('capital') }}" required autocomplete="capital" autofocus>
                                        <div id="CapitalError"> </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="activity">{{ __('Company activity') }}</label>
                                        <input id="activity" onkeyup="laststep()" type="text" class="form-control " name="activity" value="{{ old('activity') }}" required autocomplete="activity" autofocus>
                                        <div id="ActivityError"> </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="note">{{ __('Add a note') }}</label>
                                        <textarea class="form-control" onkeyup="laststep()" id="note" name="note" value="" rows="4">{!!old('note')!!}</textarea>

                                    </div>
                                </div>
                            </div>

                            <div v-show="currentstep == 3">
                                <!-- Order data form fields -->
                                <div class="card content">
                                    <div class="card-header content-header">
                                        <h3>{{ __('Personal Information') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 ">
                                                <h6>{{ __('Name') }} </h6>
                                                <h5 id="namesp" ></h5>
                                            </div>
                                            <div class="col-md-4 border-right border-left border-dark">
                                                <h6>{{ __('Email') }}</h6>
                                                <h5 id="emailsp" ></h5>
                                            </div>
                                            <div class="col-md-4 ">
                                                <h6>{{ __('Phone Number') }}</h6>
                                                <h5 id="phonesp"></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="card content">
                                    <div class="card-header content-header">
                                        <h3>{{ __('Company Information') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 ">
                                                <h6>{{ __('Company Name') }}</h6>
                                                <h5 id="compsp"></h5>
                                                </div>
                                            <div class="col-md-4 border-right border-left border-dark">
                                                <h6>{{ __('Number of partners') }}</h6>
                                                <h5 id="partsp"></h5>
                                            </div>
                                            <div class="col-md-4 ">
                                                <h6>{{ __('Capital') }}</h6>
                                                <h5 id="capitalsp"></h5>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4 ">
                                                <h6>{{ __('Company Location') }}</h6>
                                                <h5 id="locsp"></h5>
                                            </div>
                                            <div class="col-md-4 border-right border-left border-dark">
                                                <h6>{{ __('Company Purpose') }}</h6>
                                                <h5 id="purpsp"></h5>
                                            </div>
                                            <div class="col-md-4 ">
                                                <h6>{{ __('Is the company already registered in another country?') }}</h6>
                                                <h5 id="registerdsp"></h5>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 ">
                                                <h6>{{ __('Notes') }}</h6>
                                                <h5 id="notesp"></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Vue.js dynamic step buttons -->
                            <step v-for="step in steps" :currentstep="currentstep" :key="step.id" :step="step" :stepcount="steps.length" @step-change="stepChanged">
                            </step>

                            <script type="x-template" id="step-navigation-template">
                                <ol class="step-indicator">
                                    <li v-for="step in steps" is="step-navigation-step" :key="step.id" :step="step" :currentstep="currentstep">
                                    </li>
                                </ol>
                            </script>

                            <script type="x-template" id="step-navigation-step-template">
                                <li :class="indicatorclass">
                                    <div class="step"><i :class="step.icon_class"></i></div>
                                    <div class="caption hidden-xs hidden-sm">{{ __('Step')}} <span v-text="step.id"></span>: <span v-text="step.title"></span></div>
                                </li>
                            </script>

                            <script type="x-template" id="step-template">
                                <div class="step-wrapper text-center" :class="stepWrapperClass">
                                    <button type="button" class="btn btn-outline-primary btn-lg" @click="lastStep" :disabled="firststep">
                                        {{ __('Back')}}
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-lg" @click="nextStep" :disabled="laststep">
                                        {{ __('Next')}}
                                    </button>
                                    <button type="submit" class="btn btn-outline-success btn-lg" v-if="laststep">
                                        {{ __('Register')}}
                                    </button>
                                </div>
                            </script>
                        </div>
                <!-- End of registration form card -->
    </div>
</div>
<!-- JavaScript functions for dynamic form elements -->
<script type='text/javascript'>
    function addFields(){
        // Function to add dynamic partner fields
        var number = document.getElementById("partners").value;
        document.getElementById("partsp").textContent = number;

        // Get the element where the inputs will be added to
        var container = document.getElementById("container");
        // Remove every children it had before
        while (container.hasChildNodes()) {
            container.removeChild(container.lastChild);
        }
        if (number <= 7){
            for (i=0;i<number;i++){
                // Append a node with a random text
                // container.appendChild(document.createTextNode("Partner Name" ));

                // Create an <input> element, set its type and name attributes
                var nlabel = document.createElement("label");
                nlabel.htmlFor = "partner-name";
                nlabel.innerHTML="{{ __('Partner Name') }}";
                container.appendChild(nlabel);
                var ninput = document.createElement("input");
                ninput.type = "text";
                ninput.name = "Partner" + i;
                ninput.classList.add("form-control");
                container.appendChild(ninput);

                var clabel = document.createElement("label");
                clabel.htmlFor = "partner-country";
                clabel.innerHTML="{{ __('Partner Nationality') }}";
                container.appendChild(clabel);
                var cinput = document.createElement("select");
                var countries = <?php echo json_encode($countries_names);?>;
                for (var country of countries){
                    var opt = document.createElement('option');
                    opt.value = country;
                    opt.innerHTML = country;
                    cinput.appendChild(opt);
                }
                cinput.type = "text";
                cinput.name = "Partner_country" + i;
                cinput.classList.add("form-control");
                container.appendChild(cinput);
                // Append a line break
                container.appendChild(document.createElement("br"));
            }
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.3/build/js/intlTelInput.min.js"></script>
    <script>
  
  document.addEventListener("DOMContentLoaded", function () {
        const input = document.querySelector("#phone");
        const dialCodeInput = document.querySelector("#dial_code");
  
        const iti = window.intlTelInput(input, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.3/build/js/utils.js",
        });
  
        // Listen to the input change event and update the hidden input with the dial code
        input.addEventListener("input", function () {
            const selectedCountryData = iti.getSelectedCountryData();
            console.log("Selected Country Data:", selectedCountryData);
  
            if (selectedCountryData) {
                dialCodeInput.value = '+' + selectedCountryData.dialCode;
                console.log("Dial Code:", dialCodeInput.value);
            } else {
                dialCodeInput.value = null;
                console.log("Dial Code is null");
            }
        });
    });
      </script>

<script>
    function laststep(){
        // Functions to update summary information on the last step
        // Generate a dynamic number of inputs
        var name = document.getElementById("name").value;
        var email = document.getElementById("email").value;
        var phone = document.getElementById("phone").value;

        var companyname = document.getElementById("company").value;
        var capital = document.getElementById("capital").value;
        // document.getElementById("country").value;
        var companylocation = document.getElementById('country').addEventListener('change', function(e) {
            document.getElementById("locsp").textContent = e.target.options[e.target.selectedIndex].getAttribute('id');
                });
        var purp = document.getElementById("activity").value;
        var regesterd = document.getElementsByName("regesterd");
        var note = document.getElementById("note").value;

        for (i = 0; i < regesterd.length; i++) {
                if (regesterd[i].checked)
                    document.getElementById("registerdsp").textContent = regesterd[i].value;
            }

        document.getElementById("namesp").textContent = name;
        document.getElementById("emailsp").textContent = email;
        document.getElementById("phonesp").textContent = phone;
        document.getElementById("compsp").textContent = companyname;
        document.getElementById("capitalsp").textContent = capital;
        document.getElementById("purpsp").textContent = purp;
        document.getElementById("notesp").textContent = note;
    }
</script>
<script>
    Vue.component("step-navigation-step", {
      template: "#step-navigation-step-template",

      props: ["step", "currentstep"],

      computed: {
        indicatorclass() {
          return {
            active: this.step.id == this.currentstep,
            complete: this.currentstep > this.step.id };

        } } });



    Vue.component("step-navigation", {
      template: "#step-navigation-template",

      props: ["steps", "currentstep"] });


    Vue.component("step", {
      template: "#step-template",

      props: ["step", "stepcount", "currentstep"],

      computed: {
        active() {
          return this.step.id == this.currentstep;
        },

        firststep() {
          return this.currentstep == 1;
        },

        laststep() {
          return this.currentstep == this.stepcount;
        },

        stepWrapperClass() {
          return {
            active: this.active };

        } },



      methods: {
        nextStep() {
          if (this.currentstep == 1) {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var phone = document.getElementById("phone").value;
            var password = document.getElementById("password").value;
            var password_confirmation = document.getElementById("password-confirm").value;
            if (name == "") {

              document.getElementById("nameError").innerHTML = "{{ __('Please fill the name field') }}";
              document.getElementById("nameError").style.color = 'red';

              return false;
            }
            if (email == "") {
            document.getElementById("emailError").innerHTML = "{{ __('Please fill the email field') }}";
            document.getElementById("emailError").style.color = 'red';
            return false;
            }

            //if email not valid
            if (email.indexOf("@", 0) < 0) {
            document.getElementById("emailError").innerHTML = "{{ __('Please fill valid email address') }}";
            document.getElementById("emailError").style.color = 'red';
            return false;
            }
            var phoneno = /^\d{10}$/;
            if (phone == "") {

                document.getElementById("phoneError").innerHTML = "{{ __('Please fill valid phone number') }}";
                document.getElementById("phoneError").style.color = 'red';
                return false;

            }
            if (!/^[0-9]+$/.test(phone)) {
                document.getElementById("phoneError").innerHTML = "{{ __('Please fill valid phone number') }}";
                document.getElementById("phoneError").style.color = 'red';
                return false;

            }


            if (password == "") {
            document.getElementById("passwordError").innerHTML = "{{ __('Please fill password field') }}";
            document.getElementById("passwordError").style.color = 'red';
            return false;
            }

    //if password does not match
            if (password != password_confirmation) {
            document.getElementById("passwordError").innerHTML = "{{ __('Password Not Matched') }}";
            document.getElementById("passwordError").style.color = 'red';
            return false;
            }
                }
                if (this.currentstep == 2) {
                    var companyname = document.getElementById("company").value;
                    var capital = document.getElementById("capital").value;
                    var partners = document.getElementById("partners").value;
                    var companylocation = document.getElementById("country").value;
                    var purp = document.getElementById("activity").value;
                    var regesterd = document.getElementsByName("regesterd");
                    var note = document.getElementById("note").value;

                    if (companylocation == "") {
                    document.getElementById("CountryError").innerHTML = "{{ __('Please fill valid company location') }}";
                    document.getElementById("CountryError").style.color = 'red';
                    return false;

                    }
                    if (companyname == "") {
                    document.getElementById("CompanyNameError").innerHTML = "{{ __('Please fill valid company name') }}";
                    document.getElementById("CompanyNameError").style.color = 'red';
                    return false;

                    }
                    if (partners == "") {
                    document.getElementById("PartnersError").innerHTML = "{{ __('Please fill valid company partners') }}";
                    document.getElementById("PartnersError").style.color = 'red';
                    return false;

                    }


                    var selected = document.querySelector('input[name="regesterd"]:checked');
                    if (!selected) {
                        document.getElementById("RegesterdErorr").innerHTML = "{{ __('Please fill valid company status') }}";
                        document.getElementById("RegesterdErorr").style.color = 'red';
                        return false;
                    }



                    // if (capital == "") {
                    // document.getElementById("CapitalError").innerHTML = "{{ __('Please fill valid company capital') }}";
                    // document.getElementById("CapitalError").style.color = 'red';
                    // return false;

                    // }
                    if (purp == "") {
                    document.getElementById("ActivityError").innerHTML = "{{ __('Please fill valid company activity') }}";
                    document.getElementById("ActivityError").style.color = 'red';
                    return false;

                    }
                }
          this.$emit("step-change", this.currentstep + 1);
        },
        lastStep() {
          this.$emit("step-change", this.currentstep - 1);
        } } });
    new Vue({
      el: "#app",

      data: {
        currentstep: 1,

        steps: [
        {
          id: 1,
          title: "{{ __('Personal Information') }}",
          icon_class: "fa fa-solid fa-user"},

        {
          id: 2,
          title: "{{ __('Company Information') }}",
          icon_class: "fa fa-solid fa-building" },

        {
          id: 3,
          title: "{{ __('Order Data') }}",
          icon_class: "fa fa-solid fa-file" }] },
      methods: {
        //create method to validate the form data before moving to the next step (email is email & password match password confirmation)
        stepChanged(step) {
          // check if the step is valid before changing (email is email & password match)
          this.currentstep = step;
        } } });
    </script>
</body>
</html>
