$(document).ready(function () {
    $.validator.addMethod(
        "noNumbers",
        function (value, element) {
            if (/\d/.test(value)) {
                return false;
            } else {
                return true;
            }
        },
        'Cannot have digits in this field.'
    );
    
    $.validator.addMethod(
        "month",
        function (value, element) {
            if (value < 1 || value > 12) {
                return false;
            } else {
                return true;
            }
        },
        'Month must be 1-12.');

    $("#createAccountForm").validate({
        rules: {
            useremail: {
                required: true,
                email: true
            },
            userpassword: {
                minlength: 6
            },
            userpasswordconfirm: {
                minlength: 6,
                equalTo: '[name="userpassword"]'
            },
            userfirst: {
                required: true,
                noNumbers: true,
            },
            userlast: {
                required: true,
                noNumbers: true,
            },
            useraddress: 'required',
            usercity: {
                required: true,
                noNumbers: true,
            },
            userzip: {
                minlength: 5,
                maxlength: 5,
                digits: true,
                required: true
            },
            userphone: {
                minlength: 10,
                maxlength: 11,
                required: true,
                digits: true
            }
        },
        messages: {
            useremail: {
                required: 'This is a required field.',
                email: 'Invalid email address',
            },

            userpassword: {
                minlength: "Your password must be at least 6 characters long."
            },
            userpasswordconfirm: {
                minlength: "Your password must be at least 6 characters long.",
                equalTo: "Your passwords do not match!"
            },

            userfirst: {
                required: 'This is a required field.',
            },

            userlast: {
                required: 'This is a required field.',
            },

            useraddress: 'This is a required field.',

            usercity: {
                required: 'This is a required field.',
            },

            userzip: {
                minlength: "ZIP must be 5 digits.",
                maxlength: "ZIP must be 5 digits.",
                required: 'This is a required field.',
            },

            userphone: {
                minlength: "Invalid phone number!",
                maxlength: "Invalid phone number!",
                required: "This is a required field.",
            },


        }
    });
    
    $("#updateaccount").validate({
        rules: {
            useremail: {
                required: true,
                email: true
            },
            userpassword: {
                minlength: 6
            },
            userpasswordconfirm: {
                minlength: 6,
                equalTo: '[name="userpassword"]'
            },
            userfirst: {
                required: true,
                noNumbers: true,
            },
            userlast: {
                required: true,
                noNumbers: true,
            },
            useraddress: 'required',
            usercity: {
                required: true,
                noNumbers: true,
            },
            userzip: {
                minlength: 5,
                maxlength: 5,
                digits: true,
                required: true
            },
            userphone: {
                minlength: 10,
                maxlength: 11,
                required: true,
                digits: true
            }
        },
        messages: {
            useremail: {
                required: 'This is a required field.',
                email: 'Invalid email address',
            },

            userpassword: {
                minlength: "Your password must be at least 6 characters long."
            },
            userpasswordconfirm: {
                minlength: "Your password must be at least 6 characters long.",
                equalTo: "Your passwords do not match!"
            },

            userfirst: {
                required: 'This is a required field.',
            },

            userlast: {
                required: 'This is a required field.',
            },

            useraddress: 'This is a required field.',

            usercity: {
                required: 'This is a required field.',
            },

            userzip: {
                minlength: "ZIP must be 5 digits.",
                maxlength: "ZIP must be 5 digits.",
                required: 'This is a required field.',
            },

            userphone: {
                minlength: "Invalid phone number!",
                maxlength: "Invalid phone number!",
                required: "This is a required field.",
            },


        }
    });
    $("#billingInfoForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },

            firstName: {
                required: true,
                noNumbers: true,
            },

            lastName: {
                required: true,
                noNumbers: true,
            },

            billingAddr: 'required',

            city: {
                required: true,
                noNumbers: true,
            },

            zip: {
                minlength: 5,
                maxlength: 5,
                digits: true,
                required: true,
            },
            ccNum: {
                minlength: 16,
                maxlength: 16,
                required: true,
                digits: true,
            },
            ccExpMonth: {
                required: true,
                digits: true,
                month: true,
            },
            ccExpYear: {
                minlength: 2,
                maxlength: 4,
                required: true,
                digits: true,
            },
            cvc: {
                minlength: 3,
                maxlength: 4,
                required: true,
                digits: true,
            },

            bitcoinAddress: 'required',
        },

        messages: {
            email: {
                required: 'This is a required field.',
                email: 'Invalid email address',
            },

            firstName: 'This is a required field.',

            lastName: 'This is a required field.',

            billingAddr: 'This is a required field.',

            city: 'This is a required field.',

            zip: {
                minlength: "ZIP must be 5 digits.",
                maxlength: "ZIP must be 5 digits.",
                required: 'This is a required field.',
            },

            ccNum: {
                minlength: "Card number must be 16 digits.",
                maxlength: "Card number must be 16 digits.",
                required: 'This is a required field.',
            },

            ccExpMonth: {
                maxlength: "Card number cannot be more than 2 digits.",
                required: 'This is a required field.',
            },

            ccExpYear: {
                minlength: "Invalid expiration year.",
                maxlength: "Invalid expiration year.",
                required: 'This is a required field.',
            },

            cvc: {
                minlength: "Invalid CVC number.",
                maxlength: "Invalid CVC number.",
                required: 'This is a required field.',
            },

            bitcoinAddress: 'This is a required field',
        },
    });
    $("#shippingInfoForm").validate({
        rules: {
            shippingFirstName: {
                required: true,
                noNumbers: true,
            },

            shippingLastName: {
                required: true,
                noNumbers: true,
            },

            shippingAddr: 'required',

            shippingcity: {
                required: true,
                noNumbers: true,
            },

            shippingzip: {
                minlength: 5,
                maxlength: 5,
                digits: true,
                required: true
            },
        },

        messages: {
            shippingFirstName: 'This is a required field.',

            shippingLastName: 'This is a required field.',

            shippingAddr: 'This is a required field.',

            shippingcity: 'This is a required field.',

            shippingzip: {
                minlength: "ZIP must be 5 digits.",
                maxlength: "ZIP must be 5 digits.",
                required: 'This is a required field.',
            },
        },
    });

})
