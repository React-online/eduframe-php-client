<?php

namespace Eduframe;

use Eduframe\Resources\Account;
use Eduframe\Resources\Address;
use Eduframe\Resources\Category;
use Eduframe\Resources\Course;
use Eduframe\Resources\Edition;
use Eduframe\Resources\Element;
use Eduframe\Resources\Enrollment;
use Eduframe\Resources\Label;
use Eduframe\Resources\Lead;
use Eduframe\Resources\LeadInterest;
use Eduframe\Resources\LeadProduct;
use Eduframe\Resources\Location;
use Eduframe\Resources\Meeting;
use Eduframe\Resources\Variant;
use Eduframe\Resources\Order;
use Eduframe\Resources\PaymentMethod;
use Eduframe\Resources\PaymentOption;
use Eduframe\Resources\PlannedCourse;
use Eduframe\Resources\Program;
use Eduframe\Resources\Referral;
use Eduframe\Resources\SignupQuestion;
use Eduframe\Resources\Teacher;
use Eduframe\Resources\CatalogProduct;
use Eduframe\Resources\CatalogVariant;

class Client
{
    public function __construct(protected Connection $connection) {
    }

    public function accounts(array $attributes = []): Account {
        return new Account($this->connection, $attributes);
    }

    public function addresses(array $attributes = []): Address {
        return new Address($this->connection, $attributes);
    }

    public function categories(array $attributes = []): Category {
        return new Category($this->connection, $attributes);
    }

    public function courses(array $attributes = []): Course {
        return new Course($this->connection, $attributes);
    }

    public function programs(array $attributes = []): Program {
        return new Program($this->connection, $attributes);
    }

    public function course_locations(array $attributes = []): Location {
        return new Location($this->connection, $attributes);
    }

    public function course_variants(array $attributes = []): Variant {
        return new Variant($this->connection, $attributes);
    }

    public function editions(array $attributes = []): Edition {
        return new Edition($this->connection, $attributes);
    }

    /**
     * @deprecated This endpoint will only return elements of type 'Course Element'
     * that are directly linked to the program edition(s). It does not consider possible blocks.
     */
    public function elements(array $attributes = []): Element {
        return new Element($this->connection, $attributes);
    }

    public function enrollments(array $attributes = []): Enrollment {
        return new Enrollment($this->connection, $attributes);
    }

    public function labels(array $attributes = []): Label {
        return new Label($this->connection, $attributes);
    }

    public function leads(array $attributes = []): Lead {
        return new Lead($this->connection, $attributes);
    }

    public function lead_interests(array $attributes = []): LeadInterest {
        return new LeadInterest($this->connection, $attributes);
    }

    public function lead_products(array $attributes = []): LeadProduct {
        return new LeadProduct($this->connection, $attributes);
    }

    public function meetings(array $attributes = []): Meeting {
        return new Meeting($this->connection, $attributes);
    }

    public function orders(array $attributes = []): Order {
        return new Order($this->connection, $attributes);
    }

    public function payment_methods(array $attributes = []): PaymentMethod {
        return new PaymentMethod($this->connection, $attributes);
    }

    public function payment_options(array $attributes = []): PaymentOption {
        return new PaymentOption($this->connection, $attributes);
    }

    public function planned_courses(array $attributes = []): PlannedCourse {
        return new PlannedCourse($this->connection, $attributes);
    }

    public function referrals(array $attributes = []): Referral {
        return new Referral($this->connection, $attributes);
    }

    public function signup_questions(array $attributes = []): SignupQuestion {
        return new SignupQuestion($this->connection, $attributes);
    }

    public function teachers(array $attributes = []): Teacher {
        return new Teacher($this->connection, $attributes);
    }

    public function catalog_products(array $attributes = []): CatalogProduct {
        return new CatalogProduct($this->connection, $attributes);
    }

    public function catalog_variants(array $attributes = []): CatalogVariant {
        return new CatalogVariant($this->connection, $attributes);
    }

    public function getConnection(): Connection {
        return $this->connection;
    }
}
