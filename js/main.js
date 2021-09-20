jQuery.validator.addMethod("membershipNumberOrPhoneNumber", function (value, element) {
    return this.optional(element) || (value.length > 4 ? value.length === 10 : true)
}, "Needs to be either Membership Number or Phone Number");