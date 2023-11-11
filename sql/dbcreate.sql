create database php;
use php;

CREATE TABLE user (
    ID INT PRIMARY KEY,
    sex VARCHAR(255),
    age INT,
    country VARCHAR(255)
);
CREATE TABLE user_input (
    TestID INT PRIMARY KEY,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES user(ID),
    purpose VARCHAR(255),
    period VARCHAR(255)
);
CREATE TABLE travel_info (
    gender VARCHAR(255),
    age INT,
    country_of_origin VARCHAR(255),
    main_activity VARCHAR(255),
    visit_duration VARCHAR(255) PRIMARY KEY,
    avg_expense_per_person DECIMAL(10, 2),
    avg_expense_per_day DECIMAL(10, 2)
);
CREATE TABLE travel_like (
    gender VARCHAR(255),
    age INT,
    country_of_origin VARCHAR(255),
    visit_location VARCHAR(255) PRIMARY KEY,
    satisfaction_avg DECIMAL(5, 2),
    count INT
);
CREATE TABLE travel_revisit (
    gender VARCHAR(255),
    age INT,
    main_activity VARCHAR(255),
    PRIMARY KEY (gender, age, main_activity),
    revisit_intent_avg DECIMAL(5, 2)
);
CREATE TABLE travel_like_avg_location (
    visit_location VARCHAR(255) PRIMARY KEY,
    recommendation_intent_avg DECIMAL(5, 2),
    satisfaction_avg DECIMAL(5, 2)
);

-- Travel Amount Table
CREATE TABLE travel_amount (
    visit_duration VARCHAR(255) PRIMARY KEY,
    avg_expense_per_person DECIMAL(10, 2),
    avg_expense_per_day DECIMAL(10, 2)
);

-- Travel Period Table
CREATE TABLE travel_period (
    visit_duration VARCHAR(255),
    month VARCHAR(255),
    PRIMARY KEY (visit_duration, month),
    count INT
);

-- Travel Like Avg Count Table
CREATE TABLE travel_like_avg_count (
    visit_count INT PRIMARY KEY,
    recommendation_intent_avg DECIMAL(5, 2),
    satisfaction_avg DECIMAL(5, 2),
    count INT
);

-- Travel Act Amount Table
CREATE TABLE travel_act_amount (
    main_activity VARCHAR(255) PRIMARY KEY,
    avg_expense_per_person DECIMAL(10, 2),
    avg_expense_per_day DECIMAL(10, 2),
    satisfaction_avg DECIMAL(5, 2)
);

-- Travel From Avg Table
CREATE TABLE travel_from_avg (
    country_of_origin VARCHAR(255) PRIMARY KEY,
    satisfaction_avg DECIMAL(5, 2),
    recommendation_intent_avg DECIMAL(5, 2),
    count INT
);

-- Travel From Act Avg Like Table
CREATE TABLE travel_from_act_avg_like (
    main_activity VARCHAR(255),
    country_of_origin VARCHAR(255),
    PRIMARY KEY (main_activity, country_of_origin),
    satisfaction_avg DECIMAL(5, 2),
    recommendation_intent_avg DECIMAL(5, 2)
);

-- From Count Table
CREATE TABLE from_count (
    country_of_origin VARCHAR(255),
    visit_count INT,
    PRIMARY KEY (country_of_origin, visit_count),
    count INT
);

-- From Airport Table
CREATE TABLE from_airport (
    country_of_origin VARCHAR(255),
    entry_exit_airport VARCHAR(255),
    PRIMARY KEY (country_of_origin, entry_exit_airport),
    count INT
);

-- Reason Amount Avg Table
CREATE TABLE reason_amount_avg (
    factors_for_visiting_korea VARCHAR(255) PRIMARY KEY,
    avg_expense_per_person DECIMAL(10, 2),
    avg_expense_per_day DECIMAL(10, 2),
    satisfaction_avg DECIMAL(5, 2)
);

-- Act Period Table
CREATE TABLE act_period (
    main_activity VARCHAR(255),
    stay_duration VARCHAR(255) PRIMARY KEY
);
