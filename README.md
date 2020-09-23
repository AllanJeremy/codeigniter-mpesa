# CodeIgniter Mpesa

This should act as a drop-in solution for *CodeIgniter 3* applications that use Mpesa functionality. Currently, only lipa na Mpesa (STK push) has been implemented as it is the most widely used. This is an opensource project though, so feel free to add the rest of the functionality.

## Structure

`config/mpesa.php` contains Mpesa configuration you may need. By default, it comes already setup with sandbox credentials, so all you need to change is the `CONSUMER_KEY` and `CONSUMER_SECRET` which you can get from [Safaricom](https://developer.safaricom.co.ke/user/me/apps) when you create a new app

`libraries/Mpesa_lib.php` is the Mpesa API abstraction implementation that contains all the methods you can use


## Getting started

Copy and paste the all directories into your `application/` directory

## Setting up

Get your consumer key and secret from [Safaricom Daraja](https://developer.safaricom.co.ke/)

Replace the values in `config/mpesa.php` to your corresponding credentials

## Using the Library

Import the library into your controller

```php
  // Load the mpesa library
  $this->load->library('mpesa_lib');
 
 // $this->mpesa_lib is how you will be accessing the library from now on
```

Call the `lipa_na_mpesa` method in your controller

```php
  // $phone - The phone number initiating the transaction - your customer's phone
  // $amount - A non-zero amount (integer)
  $this->mpesa_lib->lipa_na_mpesa($phone, $amount)
 ```
 
 This should trigger an STK push request on your customer's device. 
 You can add this to an API request endpoint that accepts a phone number and amount and pass those into the `lipa_na_mpesa` method
 
 ## Handling the transaction
 
 If a transaction succeeds or fails, you'd want to know about it. That's where your callback url comes in. This is where Mpesa will send more information about a transaction to your application. 
 
 Ideally, you can create a controller specifically for handling the transaction requests and map your callback url to it. For example: 
 `controllers/payments/Handler.php` would probably result in your callback url being something on the lines of `site.com/payments/handler`.

More details on how this works can again be found through [Daraja.](https://developer.safaricom.co.ke/docs#lipa-na-m-pesa-online-payment)
 
 The callback urls can be set through `config/mpesa.php`
 
 Details on what kind of information is returned by the Mpesa API upon completion can be found here.

## Conclusion
With that, you should be able to implement both the request and handling of Mpesa requests. 
