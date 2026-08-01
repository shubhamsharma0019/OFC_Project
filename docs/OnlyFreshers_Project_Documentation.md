# OnlyFreshers Project Documentation

Generated on: 31 July 2026  
Project Type: Laravel 13 REST API  
Backend Stack: PHP 8.3+, Laravel Framework, Laravel Sanctum, SQLite/MySQL compatible migrations

## 1. Project Overview

OnlyFreshers ek fresher hiring aur skill-development platform ka backend API project hai. System me four major roles hain: Fresher, Company, Training Partner, aur Admin. Freshers profile create karte hain, initial assessment dete hain, jobs ke liye apply karte hain, courses me enroll hote hain, payment karte hain, training complete karte hain, final assessment dete hain aur certificate receive karte hain. Companies jobs post karti hain, applications review karti hain aur interviews schedule karti hain. Training partners courses manage karte hain, enrolled freshers ka progress update karte hain aur certificate generate karte hain. Admin complete platform governance handle karta hai.

## 2. Core Actors

| Actor | Purpose |
| --- | --- |
| Public User | Active jobs, active courses, approved training partners aur certificates verify kar sakta hai. |
| Fresher | Profile, assessments, job applications, course enrollments, payments, certificates. |
| Company | Company profile, job management, applications review, interview scheduling. |
| Training Partner | Institute profile, course management, enrollment progress, certificates. |
| Admin | Dashboard, user/profile approvals, job/course moderation, applications/enrollments monitoring, assessment questions. |

## 3. Authentication Flow

1. User `POST /api/auth/register` se account banata hai.
2. Allowed roles: `fresher`, `company`, `training_partner`, `admin`.
3. User `POST /api/auth/login` se login karta hai.
4. Laravel Sanctum token generate hota hai.
5. Protected APIs me `Authorization: Bearer <token>` required hai.
6. Blocked user login nahi kar sakta.
7. User `POST /api/auth/logout` se current token revoke kar sakta hai.
8. User `POST /api/auth/logout-all` se all tokens revoke kar sakta hai.

## 4. Public Discovery Flow

Public side bina login ke platform data discover karta hai.

| Flow | APIs | Rules |
| --- | --- | --- |
| Jobs Browse | `GET /api/jobs`, `GET /api/jobs/{job}` | Sirf `active` jobs visible. |
| Courses Browse | `GET /api/courses`, `GET /api/courses/{course}` | Sirf `active` courses visible. |
| Training Partners Browse | `GET /api/training-partners`, `GET /api/training-partners/{id}` | Sirf `approved` partner with active user visible. |
| Certificate Verify | `GET /api/certificates/verify/{certificateNumber}` | Certificate number valid hone par certificate, fresher, course details return hote hain. |

## 5. Fresher Module

### 5.1 Fresher Profile

APIs:
- `GET /api/fresher/profile`
- `POST /api/fresher/profile`

Profile fields include photo, phone, city, qualification, college name, passing year, skills, resume, and profile completion. Profile save/update ke baad fresher job applications, assessments, course enrollments aur certificates ke liye eligible hota hai.

### 5.2 Initial Assessment

APIs:
- `POST /api/fresher/assessment/start`
- `GET /api/fresher/assessment/{attempt}/questions`
- `POST /api/fresher/assessment/{attempt}/submit`
- `GET /api/fresher/assessment/{attempt}/result`

Flow:
1. Fresher assessment start karta hai.
2. Active initial questions categories ke basis par fetch hoti hain: `technical`, `aptitude`, `communication`.
3. Fresher har active question ka answer submit karta hai.
4. System correct answers calculate karta hai.
5. Scores generate hote hain: technical, aptitude, communication, overall.
6. Result `completed` store hota hai aur recommended track return hota hai.

### 5.3 Job Application

APIs:
- `POST /api/fresher/jobs/{job}/apply`
- `GET /api/fresher/applications`

Rules:
- Sirf `fresher` role apply kar sakta hai.
- Fresher profile required hai.
- Job `active` honi chahiye.
- Application last date expire nahi honi chahiye.
- Same fresher same job par duplicate apply nahi kar sakta.

Application statuses:
`applied`, `under_review`, `shortlisted`, `interview_scheduled`, `hired`, `rejected`.

### 5.4 Course Enrollment And Payment

APIs:
- `POST /api/fresher/courses/{course}/enroll`
- `GET /api/fresher/enrollments`
- `GET /api/fresher/enrollments/{courseEnrollment}`
- `POST /api/fresher/enrollments/{courseEnrollment}/payment`
- `GET /api/fresher/enrollments/{courseEnrollment}/payments`

Flow:
1. Fresher active course me enroll karta hai.
2. Enrollment default `pending`, payment `pending`, training `not_started`.
3. Payment successful hone par enrollment `enrolled`, payment status `paid` hota hai.
4. Training partner payment ke baad training progress update kar sakta hai.

Enrollment statuses:
`pending`, `enrolled`, `completed`, `cancelled`.

Payment statuses:
Enrollment level: `pending`, `paid`, `failed`. Payment record level: `pending`, `success`, `failed`.

### 5.5 Final Assessment And Certificate

APIs:
- `POST /api/fresher/enrollments/{courseEnrollment}/final-assessment/start`
- `GET /api/fresher/final-assessment/{attempt}/questions`
- `POST /api/fresher/final-assessment/{attempt}/submit`
- `GET /api/fresher/final-assessment/{attempt}/result`
- `GET /api/fresher/certificates`
- `GET /api/fresher/certificates/{certificate}`
- `GET /api/fresher/certificates/{certificate}/download`

Rules:
- Final assessment course enrollment se linked hota hai.
- Payment completed aur training completed hone ke baad final assessment ka practical value hai.
- Result `pass` ya `fail` hota hai.
- Certificate tabhi generate ho sakta hai jab final assessment `pass` ho, training 100% complete ho, enrollment completed ho, aur payment paid ho.

## 6. Company Module

### 6.1 Company Profile

APIs:
- `GET /api/company/profile`
- `POST /api/company/profile`

Company profile me company name, logo, email, phone, industry, website, address, description aur approval status store hota hai. New/updated profile admin approval ke liye `pending` state me ja sakti hai.

Approval statuses:
`pending`, `approved`, `rejected`, `blocked`.

### 6.2 Job Management

APIs:
- `GET /api/company/jobs`
- `POST /api/company/jobs`
- `GET /api/company/jobs/{job}`
- `PUT /api/company/jobs/{job}`
- `PATCH /api/company/jobs/{job}/status`

Rules:
- Company apne hi jobs manage kar sakti hai.
- Job fields include title, description, required skills, qualification, location, salary, job type, openings, hiring mode, last date, status.
- Hiring modes: `direct`, `fast_track`.
- Job statuses: `draft`, `active`, `inactive`, `removed`.

### 6.3 Application Review And Interview

APIs:
- `GET /api/company/applications`
- `GET /api/company/applications/{jobApplication}`
- `PATCH /api/company/applications/{jobApplication}/status`
- `POST /api/company/applications/{jobApplication}/interview`
- `GET /api/company/interviews`
- `PATCH /api/company/interviews/{interview}/status`

Flow:
1. Company applications list dekhti hai.
2. Application status update karti hai.
3. Shortlisted candidate ke liye interview schedule karti hai.
4. Interview status scheduled, completed, cancelled me update hota hai.

Interview modes:
`online`, `offline`.

## 7. Training Partner Module

### 7.1 Training Partner Profile

APIs:
- `GET /api/training-partner/profile`
- `POST /api/training-partner/profile`

Profile includes institute name, logo, email, phone, location, website, about institute, verification document, approval status, rejection reason.

### 7.2 Course Management

APIs:
- `GET /api/training-partner/courses`
- `POST /api/training-partner/courses`
- `GET /api/training-partner/courses/{course}`
- `PUT /api/training-partner/courses/{course}`
- `PATCH /api/training-partner/courses/{course}/status`

Rules:
- Sirf approved training partner courses manage kar sakta hai.
- Course modes: `online`, `offline`, `hybrid`.
- Course statuses: `active`, `inactive`, `removed`.

### 7.3 Enrollment Progress

APIs:
- `GET /api/training-partner/enrollments`
- `GET /api/training-partner/enrollments/{courseEnrollment}/progress`
- `PATCH /api/training-partner/enrollments/{courseEnrollment}/progress`

Rules:
- Sirf partner ke own courses ke enrollments visible/updateable.
- Payment `paid` hone ke baad progress update allowed hai.
- Cancelled enrollment update nahi hota.
- Progress 100% hone par training and enrollment completed mark ho sakte hain.

Progress statuses:
`not_started`, `in_progress`, `completed`.

### 7.4 Certificate Generation

APIs:
- `POST /api/training-partner/enrollments/{courseEnrollment}/certificate`
- `GET /api/training-partner/certificates`
- `GET /api/training-partner/certificates/{certificate}`

Certificate generation conditions:
- Training partner approved ho.
- Enrollment same partner ke course se linked ho.
- Enrollment payment status `paid` ho.
- Enrollment status `completed` ho.
- Training status `completed` ho.
- Training progress `100%` and `completed` ho.
- Final assessment result `pass` ho.
- Duplicate certificate already generated na ho.

Certificate number format: `OF-CERT-YYYY-RANDOM`.

## 8. Admin Module

### 8.1 Admin Dashboard

API:
- `GET /api/admin/dashboard`

Dashboard counts cover users, companies, training partners, jobs, courses, applications, enrollments, payments, and certificates.

### 8.2 Fresher Management

APIs:
- `GET /api/admin/freshers`
- `GET /api/admin/freshers/{fresher}`
- `PATCH /api/admin/freshers/{fresher}/status`

Admin freshers list/search/filter kar sakta hai aur user status `active` or `blocked` kar sakta hai.

### 8.3 Company Management

APIs:
- `GET /api/admin/companies`
- `GET /api/admin/companies/{companyProfile}`
- `POST /api/admin/companies/{companyProfile}/approve`
- `POST /api/admin/companies/{companyProfile}/reject`
- `PATCH /api/admin/companies/{companyProfile}/user-status`

Admin company profile approve/reject kar sakta hai. Reject ke time rejection reason store hota hai. User account active/blocked bhi ho sakta hai.

### 8.4 Training Partner Management

APIs:
- `GET /api/admin/training-partners`
- `GET /api/admin/training-partners/{trainingPartnerProfile}`
- `POST /api/admin/training-partners/{trainingPartnerProfile}/approve`
- `POST /api/admin/training-partners/{trainingPartnerProfile}/reject`
- `PATCH /api/admin/training-partners/{trainingPartnerProfile}/user-status`

Admin training partner approval, rejection reason, and account status manage karta hai.

### 8.5 Assessment Question Management

APIs:
- `GET /api/admin/assessment/questions`
- `POST /api/admin/assessment/questions`
- `PUT /api/admin/assessment/questions/{question}`
- `PATCH /api/admin/assessment/questions/{question}/status`

Admin initial/final assessment questions create/update/activate/deactivate karta hai.

### 8.6 Job, Course, Application, Enrollment Monitoring

APIs:
- `GET /api/admin/jobs`
- `GET /api/admin/jobs/{job}`
- `PATCH /api/admin/jobs/{job}/status`
- `GET /api/admin/courses`
- `GET /api/admin/courses/{course}`
- `PATCH /api/admin/courses/{course}/status`
- `GET /api/admin/applications`
- `GET /api/admin/applications/{jobApplication}`
- `GET /api/admin/enrollments`
- `GET /api/admin/enrollments/{courseEnrollment}`

Admin platform-wide moderation aur monitoring karta hai.

## 9. Notification Module

APIs:
- `GET /api/notifications`
- `GET /api/notifications/unread-count`
- `PATCH /api/notifications/read-all`
- `PATCH /api/notifications/{notification}/read`

Notification table user-specific messages store karta hai. User sirf apni notifications read/update kar sakta hai.

## 10. Database Modules

| Table | Description |
| --- | --- |
| `users` | Login identity, role, status. |
| `fresher_profiles` | Fresher details, skills, resume, profile completion. |
| `company_profiles` | Company metadata and approval workflow. |
| `training_partner_profiles` | Institute metadata and approval workflow. |
| `assessment_questions` | Initial/final questions and correct options. |
| `assessment_attempts` | Fresher assessment session. |
| `assessment_answers` | Submitted answer per question. |
| `assessment_results` | Category scores, overall score, recommendation/result. |
| `jobs` | Company job posts. |
| `job_applications` | Fresher job applications. |
| `interviews` | Interview schedule and status. |
| `courses` | Training partner courses. |
| `course_enrollments` | Fresher course enrollment lifecycle. |
| `payments` | Course payment transactions. |
| `training_progress` | One progress record per enrollment. |
| `certificates` | Generated certificates and verification numbers. |
| `notifications` | User notifications. |
| `personal_access_tokens` | Laravel Sanctum API tokens. |

## 11. End-To-End Business Flows

### Fresher Placement Flow

1. Fresher registers and logs in.
2. Fresher profile completes.
3. Fresher initial assessment starts and submits answers.
4. Public active jobs browse karta hai.
5. Fresher active job par apply karta hai.
6. Company application review karti hai.
7. Company status update karti hai: under review, shortlisted, hired/rejected.
8. Interview scheduled hone par interview record create hota hai.
9. Interview completed/cancelled mark hota hai.

### Skill Training And Certificate Flow

1. Training partner registers and profile submits.
2. Admin training partner approve karta hai.
3. Training partner course create karta hai.
4. Fresher public active courses browse karta hai.
5. Fresher course enroll karta hai.
6. Fresher payment karta hai.
7. Payment success par enrollment paid/enrolled hota hai.
8. Training partner progress update karta hai.
9. Progress 100% par training completed hoti hai.
10. Fresher final assessment submit karta hai.
11. Pass result ke baad training partner certificate generate karta hai.
12. Fresher certificate list/download karta hai.
13. Public certificate number se certificate verify kar sakta hai.

### Company Approval And Job Publishing Flow

1. Company registers.
2. Company profile creates/updates.
3. Admin company profile approve/reject karta hai.
4. Approved company job create karti hai.
5. Job draft/active/inactive/removed statuses se control hota hai.
6. Public side par sirf active jobs visible hote hain.

### Training Partner Approval And Course Publishing Flow

1. Training partner registers.
2. Institute profile and verification document submit hota hai.
3. Admin approve/reject karta hai.
4. Approved partner courses create/update karta hai.
5. Public side par sirf active courses visible hote hain.

## 12. Status Reference

| Entity | Status Values |
| --- | --- |
| User | `active`, `blocked` |
| Company Profile | `pending`, `approved`, `rejected`, `blocked` |
| Training Partner Profile | `pending`, `approved`, `rejected`, `blocked` |
| Job | `draft`, `active`, `inactive`, `removed` |
| Job Application | `applied`, `under_review`, `shortlisted`, `interview_scheduled`, `hired`, `rejected` |
| Interview | `scheduled`, `completed`, `cancelled` |
| Course | `active`, `inactive`, `removed` |
| Course Enrollment | `pending`, `enrolled`, `completed`, `cancelled` |
| Enrollment Payment | `pending`, `paid`, `failed` |
| Payment Transaction | `pending`, `success`, `failed` |
| Training Progress | `not_started`, `in_progress`, `completed` |
| Assessment Attempt | `in_progress`, `submitted` |
| Assessment Result | `completed`, `pass`, `fail` |

## 13. Setup Notes

Expected setup:
1. Install PHP 8.3 or higher.
2. Run `composer install`.
3. Copy `.env.example` to `.env`.
4. Run `php artisan key:generate`.
5. Configure database.
6. Run `php artisan migrate`.
7. Run `php artisan serve`.

Current local note: `php artisan route:list` could not run because local PHP is `8.2.12`, while `composer.json` requires PHP `^8.3`.

## 14. API Security Notes

- Protected routes use Laravel Sanctum authentication.
- Role checks are implemented inside controllers.
- Users marked `blocked` cannot login.
- Public endpoints expose only active/approved records.
- Certificate verification is public but depends on unique certificate number.

## 15. Recommended Future Improvements

- Add centralized middleware for role authorization.
- Add OpenAPI/Swagger documentation.
- Add seeders for admin user and demo data.
- Add automated tests for major flows: auth, fresher assessment, job application, payment, certificate.
- Standardize payment status naming between enrollment and payment transaction.
- Add dedicated PDF generation for certificates if production needs actual PDF certificates.

## 16. Flow Diagrams

### 16.1 Whole Platform Flow Diagram

```text
Public User
    |
    +--> Browse Active Jobs
    +--> Browse Active Courses
    +--> Browse Approved Training Partners
    +--> Verify Certificate Number

Fresher
    |
    +--> Register/Login
    +--> Complete Profile
    +--> Initial Assessment
    +--> Apply For Jobs
    +--> Enroll In Course
    +--> Make Payment
    +--> Complete Training
    +--> Final Assessment
    +--> View/Download Certificate

Company
    |
    +--> Register/Login
    +--> Submit Company Profile
    +--> Wait For Admin Approval
    +--> Create/Publish Jobs
    +--> Review Applications
    +--> Schedule Interviews
    +--> Hire/Reject Candidates

Training Partner
    |
    +--> Register/Login
    +--> Submit Institute Profile
    +--> Wait For Admin Approval
    +--> Create/Manage Courses
    +--> Track Paid Enrollments
    +--> Update Training Progress
    +--> Generate Certificates

Admin
    |
    +--> Review Dashboard
    +--> Manage Freshers
    +--> Approve/Reject Companies
    +--> Approve/Reject Training Partners
    +--> Manage Assessment Questions
    +--> Moderate Jobs/Courses
    +--> Monitor Applications/Enrollments
```

### 16.2 Authentication Flow Diagram

```text
User
    |
    +--> Register
    |        |
    |        +--> Validate name/email/mobile/password/role
    |        +--> Create User
    |        +--> Generate Sanctum Token
    |
    +--> Login
             |
             +--> Validate Email + Password
             +--> Check User Status
             |        |
             |        +--> blocked: Login Denied
             |        +--> active: Token Generated
             |
             +--> Access Protected APIs
                      |
                      +--> Logout Current Device
                      +--> Logout All Devices
```

### 16.3 Public Discovery Flow Diagram

```text
Public User
    |
    +--> Jobs Listing
    |        |
    |        +--> Only active jobs
    |        +--> Job detail page/API
    |
    +--> Courses Listing
    |        |
    |        +--> Only active courses
    |        +--> Course detail page/API
    |
    +--> Training Partner Listing
    |        |
    |        +--> Only approved partners
    |        +--> Only active partner courses
    |
    +--> Certificate Verification
             |
             +--> Valid certificate: Details returned
             +--> Invalid certificate: Error returned
```

### 16.4 Fresher Complete Flow Diagram

```text
Fresher Register/Login
    |
    +--> Save Profile
             |
             +--> Initial Assessment
             |        |
             |        +--> Start Attempt
             |        +--> Fetch Questions
             |        +--> Submit Answers
             |        +--> Result + Recommended Track
             |
             +--> Job Flow
             |        |
             |        +--> Browse Active Jobs
             |        +--> Apply
             |        +--> Track Status
             |        +--> Interview/Hired/Rejected
             |
             +--> Training Flow
                      |
                      +--> Browse Active Courses
                      +--> Enroll
                      +--> Payment
                      +--> Training Progress
                      +--> Final Assessment
                      +--> Certificate Download
```

### 16.5 Initial Assessment Flow Diagram

```text
Fresher
    |
    +--> Start Initial Assessment
             |
             +--> Attempt status: in_progress
             +--> Fetch active initial questions
             +--> Submit answers
             +--> Calculate technical score
             +--> Calculate aptitude score
             +--> Calculate communication score
             +--> Calculate overall score
             +--> Save result: completed
             +--> Attempt status: submitted
```

### 16.6 Fresher Job Application Flow Diagram

```text
Completed Fresher Profile
    |
    +--> Select Active Job
             |
             +--> Check job status
             |        |
             |        +--> inactive/draft/removed: Stop
             |        +--> active: Continue
             |
             +--> Check application last date
             |        |
             |        +--> expired: Stop
             |        +--> valid: Continue
             |
             +--> Check duplicate application
                      |
                      +--> duplicate found: Stop
                      +--> create application: applied
                               |
                               +--> Company review
                               +--> shortlisted/interview_scheduled/hired/rejected
```

### 16.7 Course Enrollment And Payment Flow Diagram

```text
Fresher Selects Active Course
    |
    +--> Create Enrollment
             |
             +--> enrollment_status: pending
             +--> payment_status: pending
             +--> training_status: not_started
             |
             +--> Make Payment
                      |
                      +--> failed
                      |        |
                      |        +--> Payment record: failed
                      |        +--> Enrollment payment_status: failed
                      |
                      +--> success
                               |
                               +--> Payment record: success
                               +--> Enrollment payment_status: paid
                               +--> Enrollment status: enrolled
                               +--> Training progress enabled
```

### 16.8 Training Progress Flow Diagram

```text
Paid Enrollment
    |
    +--> Training Partner Opens Enrollment
             |
             +--> Verify ownership of course
             +--> Update progress percentage
             +--> Update current status
             +--> Add short remark
                      |
                      +--> 0%: not_started
                      +--> 1-99%: in_progress
                      +--> 100%: completed
                               |
                               +--> enrollment_status: completed
                               +--> training_status: completed
```

### 16.9 Final Assessment And Certificate Flow Diagram

```text
Completed Training + Paid Enrollment
    |
    +--> Fresher Starts Final Assessment
             |
             +--> Fetch final questions
             +--> Submit answers
             +--> Calculate result
                      |
                      +--> fail
                      |        |
                      |        +--> Certificate blocked
                      |
                      +--> pass
                               |
                               +--> Training Partner generates certificate
                                        |
                                        +--> Check duplicate certificate
                                        +--> Generate certificate number
                                        +--> Create certificate file
                                        +--> Save certificate record
                                        +--> Fresher download enabled
                                        +--> Public verification enabled
```

### 16.10 Company Flow Diagram

```text
Company Register/Login
    |
    +--> Create/Update Company Profile
             |
             +--> approval_status: pending
             |
             +--> Admin Review
                      |
                      +--> rejected
                      |        |
                      |        +--> rejection_reason saved
                      |
                      +--> approved
                               |
                               +--> Create Jobs
                               +--> Publish active jobs
                               +--> Receive applications
                               +--> Update application status
                               +--> Schedule interviews
                               +--> Complete hiring decision
```

### 16.11 Company Job And Interview Flow Diagram

```text
Approved Company
    |
    +--> Create Job
    |        |
    |        +--> draft / active / inactive / removed
    |        +--> active jobs visible publicly
    |
    +--> Application Received
             |
             +--> applied
             +--> under_review
             +--> shortlisted
             |        |
             |        +--> Create Interview
             |                 |
             |                 +--> online/offline
             |                 +--> scheduled/completed/cancelled
             |
             +--> hired/rejected
```

### 16.12 Training Partner Flow Diagram

```text
Training Partner Register/Login
    |
    +--> Create/Update Institute Profile
             |
             +--> approval_status: pending
             |
             +--> Admin Review
                      |
                      +--> rejected
                      |        |
                      |        +--> rejection_reason saved
                      |
                      +--> approved
                               |
                               +--> Create Courses
                               +--> Manage Course Status
                               +--> View Paid Enrollments
                               +--> Update Progress
                               +--> Generate Certificate
```

### 16.13 Admin Flow Diagram

```text
Admin Login
    |
    +--> Dashboard
    |        |
    |        +--> Users count
    |        +--> Companies count
    |        +--> Partners count
    |        +--> Jobs/Courses count
    |        +--> Payments/Certificates count
    |
    +--> Fresher Management
    |        |
    |        +--> list/search/show
    |        +--> active/blocked
    |
    +--> Company Management
    |        |
    |        +--> approve/reject
    |        +--> active/blocked user
    |
    +--> Training Partner Management
    |        |
    |        +--> approve/reject
    |        +--> active/blocked user
    |
    +--> Assessment Question Management
    |        |
    |        +--> create/update
    |        +--> activate/deactivate
    |
    +--> Monitoring
             |
             +--> jobs
             +--> courses
             +--> applications
             +--> enrollments
```

### 16.14 Notification Flow Diagram

```text
System Event
    |
    +--> Create Notification For User
             |
             +--> User Fetches Notifications
             +--> User Checks Unread Count
             +--> User Marks Single Notification Read
             +--> User Marks All Notifications Read
```
