package com.hotelbooking;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;


@SpringBootApplication
public class CheckoutProcessApplication {

    public static void main(String[] args) {
        SpringApplication.run(CheckoutProcessApplication.class, args);
    }
}


class Payment {
    private String fullName;
    private String email;
    private String cardNumber;
    private String expiryDate;
    private String cvv;

    // Getters and Setters
    public String getFullName() {
        return fullName;
    }

    public void setFullName(String fullName) {
        this.fullName = fullName;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getCardNumber() {
        return cardNumber;
    }

    public void setCardNumber(String cardNumber) {
        this.cardNumber = cardNumber;
    }

    public String getExpiryDate() {
        return expiryDate;
    }

    public void setExpiryDate(String expiryDate) {
        this.expiryDate = expiryDate;
    }

    public String getCvv() {
        return cvv;
    }

    public void setCvv(String cvv) {
        this.cvv = cvv;
    }
}


@RestController
@RequestMapping("/api/checkout")
class CheckoutController {

    @PostMapping("/process")
    public ResponseEntity<String> processPayment(@RequestBody Payment payment) {
        
        if (payment.getCardNumber().length() != 16 || payment.getCvv().length() != 3) {
            return ResponseEntity.badRequest().body("Invalid payment details. Please check your card information.");
        }

        
        String message = "Payment processed successfully for " + payment.getFullName() + " with email " + payment.getEmail();
        return ResponseEntity.ok(message);
    }
}
