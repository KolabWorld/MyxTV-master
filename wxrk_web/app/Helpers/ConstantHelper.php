<?php

namespace App\Helpers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
*/

class ConstantHelper
{

	const PROJECT_NAME = 'WorkStudy';
	const DEAFULT_CURRENCY = 'INR';

	const ROLE_ADMIN = 'admin';
	const ROLE_VENDOR = 'vendor';

	const TYPE_DESIGNER = 'designer';
	const TYPE_AMBASSADOR = 'ambassador';

	// Email Template Keywords
	const EMAIL_TEMPLATE_KEYWORDS = [
		"CLIENT_NAME",
		"CLIENT_EMAIL",
		"CLIENT_PASSWORD",
		"COMPANY_NAME",
		"WHMCS_LINK",
		"SIGNATURE",
		"TICKET_ID",
		"TICKET_SUBJECT",
		"TICKET_DEPARTMENT",
		"TICKET_PRIORITY",
		"TICKET_STATUS",
		"TICKET_LINK",
		"TICKET_MESSAGE",
		"TICKET_AUTO_CLOSE_TIME",
		"ORDER_NUMBER",
		"ORDER_DETAIL",
		"INVOICE_NUMBER",
		"INVOICE_DATE",
		"INVOICE_DUE_DATE",
		"INVOICE_HTML_CONTENT",
		"INVOICE_LAST_PAYMENT_AMOUNT",
		"INVOICE_LAST_PAYMENT_TRANSACTIONID",
		"INVOICE_AMOUNT_PAID",
		"INVOICE_BALANCE",
		"INVOICE_STATUS",
		"INVOICE_LINK"
	];



	const ROLES = [
		self::ROLE_ADMIN,
		self::ROLE_VENDOR
	];

	const ADMIN_ROLES = [
		self::ROLE_ADMIN,
		self::ROLE_VENDOR	
	];
	const VENDOR_ROLES=[
		self::ROLE_ADMIN,
        self::ROLE_VENDOR
	];
	const MONDAY = 'Monday';
	const TUESDAY = 'Tuesday';
	const WEDNESDAY = 'Wednesday';
	const THURSDAY = 'Thursday';
	const FRIDAY = 'Friday';
	const SATURDAY = 'Saturday';
	const SUNDAY = 'Sunday';
	const WEEK_DAYS = [self::MONDAY, self::TUESDAY, self::WEDNESDAY, self::THURSDAY, self::FRIDAY, self::SATURDAY, self::SUNDAY];


	const ADDRESS_TYPE = ['primary', 'alternate', 'billing', 'default', 'shipping', 'work', 'home', 'mailing', 'permanent', 'temporary'];
	const COUNTRIES = ['India', 'America', 'Dubai', 'Colombia'];
	const LABEL_COUNTRIES = ['Total', 'India', 'America', 'Dubai', 'Colombia'];


	const NEW = 'new';
	const ACTIVE = 'active';
	const IN_ACTIVE = 'inactive';
	const PENDING = 'pending';
	const CANCELLED = 'cancelled';
	const TERMINATED = 'terminated';
	const SOLD = 'sold';

	const SUSPENDED = 'suspended';

	const SLIDER_1 = 'slider1';
	const SLIDER_2 = 'slider2';
	const SLIDER_3 = 'slider3';

	const IMAGE = 'image';
	const VIDEO = 'video';

	const STATUS = [self::ACTIVE, self::IN_ACTIVE, self::CANCELLED, self::TERMINATED, self::SUSPENDED];
	const SIZEGUIDESTATUS = [self::ACTIVE, self::IN_ACTIVE];
	const SLIDER_TYPE = [self::SLIDER_1, self::SLIDER_2, self::SLIDER_3];
	const ATTACHMENT_TYPE = [self::IMAGE, self::VIDEO];
	const USER_STATUS = [self::ACTIVE, self::IN_ACTIVE, self::PENDING, self::REJECTED];
	const CUSTOMER_STATUS = [self::ACTIVE, self::IN_ACTIVE];
	const PRODUCT_STATUS = [self::ACTIVE, self::IN_ACTIVE, self::PENDING];
	const PORTFOLIO_STATUS = [self::ACTIVE, self::IN_ACTIVE, self::PENDING];
	const MARRIED = 'married';
	const UNMARRIED = 'unmarried';
	const MARITAL_STATUS = [self::MARRIED, self::UNMARRIED];

	const FIXED = 'fixed';
	const PERCENTAGE = 'percentage';
	const OFFER_TYPE = [self::FIXED, self::PERCENTAGE];


	const MALE = 'male';
	const FEMALE = 'female';
	const TRANSGENDER = 'transgender';
	const GENDER = [self::MALE, self::FEMALE, self::TRANSGENDER];

	const REGISTER = 'Register';
	const TRANSFER = 'Transfer';
	const TRANSFERED = 'Transfered';
	const DOMAINTYPES = [self::REGISTER, self::TRANSFER];

	const Pending = 'Pending';
	const PendingTransfer = 'Pending Transfer';
	const Active = 'Active';
	const Expired = 'Expired';
	const Cancelled = 'Cancelled';
	const Fraud = 'Fraud';
	const TransferredAway = 'Transferred Away';

	const DOMAINSTATUS = [self::Pending, self::PendingTransfer, self::Active, self::Expired, self::Cancelled, self::Fraud, self::TransferredAway];
	// OTP based validations:
	const OTP_EXPIRE_LIMT = 900;   //in seconds
	const OTP_EXPIRE_MINUTE = 15;   //in minutes

	const OTP_MIN_SIZE = 5;
	const OTP_MAX_SIZE = 6;

	// Auth Clients
	const AUTH_CLIENT_ANDROID = 'android';
	const AUTH_CLIENT_IOS = 'ios';
	const AUTH_CLIENT_WEB = 'web';
	const AUTH_CLIENT_ADMIN = 'admin';

	const AUTH_TOKEN_EXPIRE_LIMT = 86400;   //in seconds

	// Auth exceptions
	const AUTH_INVALID_PASSWORD = "INVALID_PASSWORD";
	const AUTH_EMAIL_NOT_FOUND = "EMAIL_NOT_FOUND";

	const FAILED = 'failed';
	const SUCCESS = 'success';
	const COMPLETE = 'complete';
	const INITIATED = 'initiated';
	const DECLINE = 'decline';

	const PAID = 'paid';
	const UNPAID = 'unpaid';
	const DRAFT = 'draft';
	const OVERDUE = 'overdue';
	const REFUNDED = 'refunded';

	//crons status
	const CRON_IDLE = 'idle';
	const CRON_RUNING = 'running';
	const CRON_STOPPED = 'stopped';
	const CRON_SUCCESS = 'success';
	const CRON_SKIPPED = 'skipped';
	const CRON_UPDATE_LIMIT = 100;
	const PLAN_VALIDITY_IN_DAYS = 30;
	const DEFAUTLT_DIAL_CODE = '+91';

	const CARD_TYPES = [
		'credit',
		'debit'
	];

	/* L E N G T H */
	const NAME_MAX_LENGTH = 191;
	const ALIAS_MAX_LENGTH = 40;
	const FULLNAME_MAX_LENGTH = 291;
	const EMAIL_MAX_LENGTH = 191;
	const MOBILE_MIN_LENGTH = 8;
	const MOBILE_MAX_LENGTH = 15;
	const PASSWORD_MIN_LENGTH = 6;
	const POSTAL_MIN_LENGTH = 5;
	const POSTAL_MAX_LENGTH = 6;
	const PAN_NUMBER_SIZE = 11;
	const GSTIN_MAX_LENGTH = 15;
	const HSN_MAX_LENGTH = 6;
	const GST_PERCENTAGE = 18;
	const ACCOUNT_MAX_LENGTH = 20;
	const DESCRIPTION_LENGTH = 5000;
	const PRODUCT_NAME_MAX_LENGTH = 299;
	const LANDMARK_MAX_LENGTH = 599;



	/*L I M I T*/
	const AGE_LIMIT = 14;
	const DOUBLE_TOTAL_DIGITS = 14;
	const DOUBLE_DECIMAL_PLACES = 4;
	const PAGE_LIMIT = 10;
	const PAGE_LIMIT_20 = 20;


	/* E M A I L */
	const MAIL_STATUS = [
		'pending',
		'success',
		'failed'
	];

	/* PAYMENT TYPES */
	const PAYMENT_TYPE_FREE = 'free';
	const PAYMENT_TYPE_ONCE = 'once';
	const PAYMENT_TYPE_RECURRING = 'recurring';
	const PAYMENT_TYPES = [
		self::PAYMENT_TYPE_FREE,
		self::PAYMENT_TYPE_ONCE,
		self::PAYMENT_TYPE_RECURRING
	];

	/* V O U C H E R S */
	const VOUCHER_TYPE_FIXED = 'fixed';
	const VOUCHER_TYPE_PERCENTAGE = 'percentage';
	const VOUCHER_DISCOUNT_TYPES = [
		self::VOUCHER_TYPE_FIXED,
		self::VOUCHER_TYPE_PERCENTAGE
	];

	/* BANNER TYPES */
	const BANNER_TYPE_CATEGORY = 'category';
	const BANNER_TYPE_SECTION = 'section';
	const BANNER_TYPES = [
		self::BANNER_TYPE_CATEGORY,
		self::BANNER_TYPE_SECTION
	];

	/* CONFIG GROUP SERVICE OPTION TYPES */
	const OPTION_TYPE_DROPDOWN = 'dropdown';
	const OPTION_TYPE_YESNO = 'yes/no';
	const OPTION_TYPE_RADIO = 'radio';
	const OPTION_TYPE_QUANTITY = 'quantity';
	const OPTION_TYPES = [
		self::OPTION_TYPE_DROPDOWN,
		self::OPTION_TYPE_YESNO,
		self::OPTION_TYPE_RADIO,
		self::OPTION_TYPE_QUANTITY
	];

	/* SUPPORT TICKET TYPES */
	const REJECTED = 'rejected';
	const ACCEPTED = 'accepted';
	const COMPLETED = 'completed';
	const HOLD = 'hold';
	const CANCELED = 'cancelled';
	const PROCESSING = 'processing';

	const OPEN = 'Open';
	const ANSWERED = 'Answered';
	const CUSTOMER_REPLY = 'Customer Reply';
	const WAITING_CLIENT_RESPONSE = 'Waiting Client Response';
	const ON_HOLD = 'On Hold';
	const IN_PROGRESS = 'In Progress';
	const CLOSED = 'Closed';

	const SUPPORT_TICKETS_STATUS = [
		self::OPEN,
		self::ANSWERED,
		self::CUSTOMER_REPLY,
		self::WAITING_CLIENT_RESPONSE,
		self::ON_HOLD,
		self::IN_PROGRESS,
		self::CLOSED,
	];

	// Welcome Email Categories
	const GENERAL_MESSAGE = 'General Messages';
	const PRODUCT_SERVICE_MESSAGE = 'Product/Service Messages';
	const INVOICE_MESSAGE = 'Invoice Messages';
	const DOMAIN_MESSAGE = 'Domain Messages';
	const ADMIN_MESSAGE = 'Admin Messages';
	const AFFILIATE_MESSAGE = 'Affiliate Messages';
	const SUPPORT_MESSAGE = 'Support Messages';
	const MESSAGES = 'Messages';

	const WELCOME_MESSAGE_CATEGORIES = [
		self::GENERAL_MESSAGE,
		self::PRODUCT_SERVICE_MESSAGE,
		self::INVOICE_MESSAGE,
		self::DOMAIN_MESSAGE,
		self::ADMIN_MESSAGE,
		self::AFFILIATE_MESSAGE,
		self::SUPPORT_MESSAGE,
		self::MESSAGES,
	];

	/* SUPPORT TICKET PRIORITIES */
	const LOW = 'low';
	const HIGH = 'high';
	const MEDIUM = 'medium';
	const CRITICAL = 'critical';
	const SUPPORT_TICKETS_PRIORITIES = [
		self::LOW,
		self::HIGH,
		self::MEDIUM,
		self::CRITICAL
	];

	const STATUS_NEW = "new";
	const SCHEDULED = "scheduled";
	const RESCHEDULE = "reschedule";
	const RESCHEDULED = "rescheduled";

	/* APPOINTMENT */
	const APPOINTMENT_STATUS = [
		self::NEW,
		self::SCHEDULED,
		self::REJECTED,
		//self::RESCHEDULE,
		self::RESCHEDULED,
		self::COMPLETED
	];



	/* O R D E R */
	const ORDER_STATUS = [
		'pending',
		'approved',
		'processing',
		'completed',
		'cancelled'
	];
	const INVOICE_STATUS = [
		self::DRAFT,
		self::SUCCESS,
		self::PENDING,
		self::COMPLETE,
		self::CANCELED,
		self::INITIATED,
	];
	const PAYMENT_STATUS = [
		self::INITIATED,
		self::SUCCESS,
		self::PENDING,
	];

	const PAYOUT_STATUS = [
		self::PROCESSING,
		self::TRANSFERED,
		self::PENDING,
		self::DECLINE
	];

	const PAYOUT_FOR = [
		'designer',
		'ambassador',
	];
	const DESIGNER_STATUS = [self::ACTIVE, self::IN_ACTIVE];
	const DESIGNER_PORTFOLOI_STATUS = [self::ACTIVE, self::IN_ACTIVE];
	const COMMON_STATUS = [self::ACTIVE, self::IN_ACTIVE];


	const INVOICE_PAYMENT_STATUS = [
		// self::PAID,
		self::UNPAID,
		self::OVERDUE,
		self::CANCELED,
		self::REFUNDED
	];
	const ORDER_STATUS_PENDING = 'pending';
	const ORDER_STATUS_APPROVED = 'approved';
	const ORDER_STATUS_PROCESSING = 'processing';
	const ORDER_STATUS_CANCELLED = 'cancelled';
	const ORDER_STATUS_COMPLETED = 'completed';

	const ORDER_PAYMENT_STATUS_PENDING = 'pending';
	const ORDER_PAYMENT_STATUS_PAID = 'paid';
	const ORDER_PAYMENT_STATUS_FAILED = 'failed';
	const ORDER_PAYMENT_STATUS_REFUNDED = 'refunded';
	const ORDER_PAYMENT_STATUS = [
		'pending',
		'paid',
		'failed',
		'refunded'
	];

	const OPTION = 'option';
	const TEXT = 'text';
	const NUMBER = 'number';
	const DECIMAL = 'decimal';
	const OPTION_TYPE = [self::OPTION,];
	const APPROVED = 'approved';
	const DEMOBILIZED = 'demobilized';	
	const CONDITIONALLY_APPROVED = 'cond-approved';
	const PASSED = 'passed';
	const CONDITIONALLY_PASS = 'cond-passed';
	const DEMOBILIZE_REQUEST ='demobilize-req.';
	const APPLICATION_STATUS = [self::PENDING,self::APPROVED,self::REJECTED,self::CONDITIONALLY_APPROVED,self::DEMOBILIZED,self:: DEMOBILIZE_REQUEST ];
	const TODAY = 'Today';
	const NEXT1WEEK = 'Next 1 Week';
	const NEXT1MONTH = 'Next 1 Month';

	const TECHNICAL_PROBLEM = 'equipment_technical_problem';
	const TECHNICAL_PROBLEM_TEXT = 'Equipment Technical Problem';
    const MECHANICAL_PROBLEM = 'equipment_mechanical_problem';
	const MECHANICAL_PROBLEM_TEXT = 'Equipment Mechanical Problem';
    const EQDOC_ERROR = 'equipment_document_error';
	const EQDOC_ERROR_TEXT = 'Equipment Document Error';
	const OPERATOR_CERTIFICATE = 'operator_certificate';
	const OPERATOR_CERTIFICATE_TEXT = 'Operator Certificate';
	const OPDOC_ERROR = 'operator_document_error';
	const OPDOC_ERROR_TEXT = 'Operator Document Error';
	const OTHERS = 'others';
	const OTHERS_TEXT = 'Others';

	const OBS_STATUS = [self::TECHNICAL_PROBLEM => self::TECHNICAL_PROBLEM_TEXT,
	self::MECHANICAL_PROBLEM => self::MECHANICAL_PROBLEM_TEXT,
	self::EQDOC_ERROR=> self::EQDOC_ERROR_TEXT,
	self::OPERATOR_CERTIFICATE=> self::OPERATOR_CERTIFICATE_TEXT,
	self::OPDOC_ERROR=> self::OPDOC_ERROR_TEXT,
	self::OTHERS=>self::OTHERS_TEXT];

	const OBS_STATUS_API = [
		['value' => self::TECHNICAL_PROBLEM, 'title' => self::TECHNICAL_PROBLEM_TEXT],
		['value' => self::MECHANICAL_PROBLEM, 'title' => self::MECHANICAL_PROBLEM_TEXT],
		['value' => self::EQDOC_ERROR, 'title'=> self::EQDOC_ERROR_TEXT],
		['value' => self::OPERATOR_CERTIFICATE, 'title'=> self::OPERATOR_CERTIFICATE_TEXT],
		['value' => self::OPDOC_ERROR, 'title'=> self::OPDOC_ERROR_TEXT],
		['value' => self::OTHERS, 'title'=>self::OTHERS_TEXT]
	];
    
	const INSPECTION_DUE = [self::TODAY,self::NEXT1WEEK,self::NEXT1MONTH];
	const EXPIRY_DOCS = [self::TODAY,self::NEXT1WEEK,self::NEXT1MONTH];
	const LAST1WEEK = 'Last 1 Week';
	const LAST15DAYS = 'Last 15 Days';
	const LAST1MONTH = 'Last 1 Month';
	const CUSTOM = 'Custom';
	const CREATED_AT = [self::TODAY,self::LAST1WEEK,self::LAST15DAYS,self::LAST1MONTH,self::CUSTOM];

	const TRAIL = 'trail';
	const STANDARD = 'standard';
	const PREMIUM = 'premium';
	const UNLIMITED = 'unlimited';
	const PLAN_NAMES_MONTHLY = [self::TRAIL, self::STANDARD, self::PREMIUM, self::UNLIMITED];
	const PLAN_NAMES_YEARLY = [self::STANDARD, self::PREMIUM, self::UNLIMITED];

	const MONTHLY = 'monthly';
	const YEARLY = 'yearly';
	const PLAN_TYPE = [self::MONTHLY, self::YEARLY];

	const FIVE = 5;
	const TEN = 10;
	const FIFTEEN = 15;
	const ALLOWEDIMAGESQTY = [self::FIVE, self::TEN, self::FIFTEEN, self::UNLIMITED];

	const ABOUT_US = 'about-us';
	const PRIVACY_POLICY = 'privacy-policy';
	const TERMS_CONDITION = 'terms-condition';
	const PAGE_TYPE = [self::ABOUT_US, self::PRIVACY_POLICY, self::TERMS_CONDITION];

	const RE_OPEN = 're-open';
	const SUPPORT_STATUS = [self::PENDING, self::RE_OPEN, self::CLOSED];
}