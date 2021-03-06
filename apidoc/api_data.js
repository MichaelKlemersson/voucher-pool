define({ "api": [
  {
    "type": "post",
    "url": "/offers",
    "title": "",
    "name": "CreateOffer",
    "group": "Offer",
    "version": "0.1.0",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>offer name</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "discount",
            "description": "<p>offer discount</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST -H 'Content-Type: application/json' -d '{\"name\":\"first offer\",\"discount\":1.00}' http://localhost:8080/api/v1/offers",
        "type": "curl"
      }
    ],
    "filename": "app/Units/Api/Http/Controllers/Offers/OfferController.php",
    "groupTitle": "Offer"
  },
  {
    "type": "get",
    "url": "/offers",
    "title": "",
    "name": "GetOffers",
    "group": "Offer",
    "version": "0.1.0",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost:8080/api/v1/offers",
        "type": "curl"
      }
    ],
    "filename": "app/Units/Api/Http/Controllers/Offers/OfferController.php",
    "groupTitle": "Offer"
  },
  {
    "type": "post",
    "url": "/recipients",
    "title": "",
    "name": "CreateRecipient",
    "group": "Recipient",
    "version": "0.1.0",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>recipient name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>recipient unique email</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST -H 'Content-Type: application/json' -d '{\"name\":\"foo bar\",\"email\":\"foo@bar.baz\"}' http://localhost:8080/api/v1/recipients",
        "type": "curl"
      }
    ],
    "filename": "app/Units/Api/Http/Controllers/Recipients/RecipientController.php",
    "groupTitle": "Recipient"
  },
  {
    "type": "get",
    "url": "/recipients",
    "title": "",
    "name": "GetRecipients",
    "group": "Recipient",
    "version": "0.1.0",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost:8080/api/v1/recipients",
        "type": "curl"
      }
    ],
    "filename": "app/Units/Api/Http/Controllers/Recipients/RecipientController.php",
    "groupTitle": "Recipient"
  },
  {
    "type": "get",
    "url": "/vouchers/check",
    "title": "",
    "name": "CheckVoucher",
    "group": "Voucher",
    "version": "0.1.0",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>the voucher code</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost:8080/api/v1/vouchers/check?code=somecode",
        "type": "curl"
      }
    ],
    "filename": "app/Units/Api/Http/Controllers/Vouchers/VoucherController.php",
    "groupTitle": "Voucher"
  },
  {
    "type": "post",
    "url": "/vouchers/generate",
    "title": "",
    "name": "CreateVouchers",
    "group": "Voucher",
    "version": "0.1.0",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "offer",
            "description": "<p>an offer id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "end_date",
            "description": "<p>a final date for all vouchers using the format YYYY-MM-DD HH:ii:ss</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST -H 'Content-Type: application/json' -d '{\"offer\":\"foo bar\",\"end_date\":\"2018-01-01 23:59:59\"}' http://localhost:8080/api/v1/vouchers/generate",
        "type": "curl"
      }
    ],
    "filename": "app/Units/Api/Http/Controllers/Vouchers/VoucherController.php",
    "groupTitle": "Voucher"
  },
  {
    "type": "get",
    "url": "/vouchers/from-recipient",
    "title": "",
    "name": "ListRecipientVouchers",
    "group": "Voucher",
    "version": "0.1.0",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>an existing recipient email</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost:8080/api/v1/vouchers/from-recipient?email=foo@bar.baz",
        "type": "curl"
      }
    ],
    "filename": "app/Units/Api/Http/Controllers/Vouchers/VoucherController.php",
    "groupTitle": "Voucher"
  }
] });
