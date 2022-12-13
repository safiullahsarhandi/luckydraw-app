<template>
    <div>
        <ValidationObserver ref="loginObserver" tag="div" v-slot="{handleSubmit}">
            <form @submit.prevent="handleSubmit(authenticate)">
                <div class="imgcontainer">
                    <h2>Committee Manager</h2>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="col-6">
                                <ValidationProvider rules="required|email" vid="email" v-slot="{errors}">
                                    <label for="uname"><b>Email address</b></label>
                                    <input type="email" v-model="form.email" placeholder="Enter Email address" name="email">
                                    <div class="text-danger">{{errors[0]}}</div>
                                </ValidationProvider>
                                <ValidationProvider rules="required" name="password" vid="password" v-slot="{errors}">
                                    <label for="psw"><b>Password</b></label>
                                    <input autocomplete="new-password" v-model="form.password" type="password" placeholder="Enter Password">
                                    <div class="text-danger">{{errors[0]}}</div>
                                </ValidationProvider>
                                <button type="submit">Login</button>
                                <span class="psw">Forgot <a href="#">password?</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </ValidationObserver>
    </div>
</template>
<script>
export default {
    data() {
        return {
            form: {},
        };
    },
    methods: {
        async authenticate() {
            let form = new FormData();
            this.buildFormData(form, this.form);
            try {
                let { data } = await axios.post('/login', form);
                    window.location.reload();
                    this.$snotify.success(data.message);
            } catch (e) {
                // statements
                console.log(e);
                if (e.response) {
                    let { errors } = e.response.data;
                    this.$refs.loginObserver.setErrors(errors);
                }
            }
        }
    }
}

</script>
<style>
/* Full-width inputs */
input[type=email], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
}

/* Set a style for all buttons */
button {
    background-color: #04AA6D;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

/* Add a hover effect for buttons */
button:hover {
    opacity: 0.8;
}

/* Extra style for the cancel button (red) */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the avatar image inside this container */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

/* Avatar image */
img.avatar {
    width: 40%;
    border-radius: 50%;
}

/* Add padding to containers */

/* The "Forgot password" text */
span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
        display: block;
        float: none;
    }

    .cancelbtn {
        width: 100%;
    }
}

</style>
