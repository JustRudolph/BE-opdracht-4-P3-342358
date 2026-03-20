# Test Plan - User Story 01: Overzicht Geleverde Producten

**Project**: Jamin Warehouse Management System  
**User Story**: 01 - Overzicht Geleverde Producten  
**Version**: 1.0  
**Date**: March 2026  
**Author**: Development Team  

---

## 1. Introduction

This test plan describes the testing strategy for User Story 01, which enables managers to view delivered products within a specific date range. The feature includes three scenarios and requires comprehensive testing to ensure all requirements are met.

---

## 2. Test Objectives

- Verify that managers can view product deliveries for a selected date range
- Confirm that delivery product details can be viewed for individual products
- Ensure appropriate error messaging when no deliveries exist in the selected period
- Validate pagination functionality (4 items per page)
- Confirm data accuracy and sorting by supplier name (A-Z)

---

## 3. Test Scope

### In Scope
- Scenario 01: Overview of delivered products within date range
- Scenario 02: Product delivery specifications
- Scenario 03: No results handling
- Stored Procedures: sp_GetDeliveredProductsByDateRange, sp_GetProductDeliverySpecifications
- Pagination with 4 items per page
- Date range validation and input handling
- Database relationships and data integrity

### Out of Scope
- Performance testing (load testing)
- Security testing (SQL injection prevention)
- Browser compatibility testing
- User authentication/authorization
- Styling and UI/UX detailed testing

---

## 4. Test Strategy

### Test Types

#### 4.1 Unit Tests
- Test database model methods
- Test stored procedure queries
- Test pagination calculations
- Test data retrieval logic

#### 4.2 Integration Tests
- Test controller methods with data
- Test view rendering with data
- Test form submission and date filtering
- Test routing and navigation

#### 4.3 SystemTests
- Test complete user workflows
- Test multi-step scenarios
- Test data consistency across operations

#### 4.4 Acceptance Tests
- Test against acceptance criteria
- Verify all three scenarios
- Confirm user expectations are met

### Test Data

**Date Range for Testing**: 2023-04-08 to 2023-04-21

**Products Available in Date Range**: Multiple products delivered during this period
- Mintnopjes (delivered multiple times)
- Schoolkrijt
- Honingdrop
- And others

**Test Scenarios**:
1. Date range WITH deliveries (April 8-19, 2023)
2. Date range WITHOUT deliveries (May 7-14, 2025)
3. Single day delivery date
4. Full month range

---

## 5. Test Cases

### Test Case 01: Scenario 01 - Overview with Valid Date Range

**Test Case ID**: TC-01-001  
**Scenario**: Scenario 01 - Overview of delivered products  
**Priority**: High  
**Type**: Integration Test  

**Preconditions**:
- User is logged into the application
- Database contains delivery records for April 2023
- Page `/delivered-products` is accessible

**Test Steps**:
1. Navigate to Home page
2. Click "Overzicht Geleverde Producten" link
3. Enter Start date: 08-04-2023
4. Enter End date: 19-04-2023
5. Click "Maak selectie" button

**Expected Results**:
- Page displays all products delivered between these dates
- Products are sorted A-Z by supplier name (Leverancier)
- Each product row shows:
  - Leverancier (Supplier) name
  - Product name
  - Barcode
  - Total quantity delivered (TotalAantalGeleverd)
  - Number of deliveries (AantalLevering)
  - Question mark link for specifications
- At least 3 products are displayed
- Pagination shows correct number of pages
- Page displays cleanly without errors

**Pass Criteria**: All expected results are met

---

### Test Case 02: Scenario 02 - Product Specifications

**Test Case ID**: TC-01-002  
**Scenario**: Scenario 02 - Product delivery specifications  
**Priority**: High  
**Type**: Integration Test  

**Preconditions**:
- User has completed TC-01-001
- Date range filter is active (08-04-2023 to 19-04-2023)
- Overview page displays delivered products

**Test Steps**:
1. Click question mark (?) button in "Specificatie" column for "Mintnopjes"
2. Review the specifications page content

**Expected Results**:
- User is directed to specifications page for Mintnopjes
- Page title shows "Specificatie Geleverde Producten"
- Product information displayed:
  - Product name: "Mintnopjes"
  - Barcode displayed
  - Date range reflected (08-04-2023 to 19-04-2023)
  - Total deliveries count shown
- Delivery details table shows:
  - Supplier name (Leverancier)
  - Contact person (Contactpersoon)
  - Delivery date (formatted as DD-MM-YYYY)
  - Quantity delivered (Aantal)
  - Next scheduled delivery date (if applicable)
- Multiple delivery records displayed for Mintnopjes
- "Terug naar Overzicht" (Back) button works

**Pass Criteria**: All specifications are displayed correctly

---

### Test Case 03: Scenario 03 - No Results Message

**Test Case ID**: TC-01-003  
**Scenario**: Scenario 03 - No deliveries in date range  
**Priority**: High  
**Type**: Integration Test  

**Preconditions**:
- User is on `/delivered-products` page
- Database contains no deliveries for the selected date range

**Test Steps**:
1. Enter Start date: 07-05-2024
2. Enter End date: 14-05-2025
3. Click "Maak selectie" button

**Expected Results**:
- Page displays message: "Er zijn geen leveringen geweest van producten in deze periode"
- No product table is shown
- Message is prominently displayed
- User can still modify date range and search again

**Pass Criteria**: Correct message is displayed for empty results

---

### Test Case 04: Pagination - First Page

**Test Case ID**: TC-01-004  
**Scenario**: Pagination - viewing first page  
**Priority**: Medium  
**Type**: Integration Test  

**Preconditions**:
- At least 5 delivered products exist in date range
- Overview page is displayed with results

**Test Steps**:
1. Observe pagination controls on page 1
2. Count number of product rows displayed

**Expected Results**:
- Exactly 4 products are displayed on page 1
- "Vorige" (Previous) button is disabled/hidden
- "Volgende" (Next) button is enabled
- Page indicator shows current page
- Total pages calculated correctly (ceiling of total/4)

**Pass Criteria**: Pagination shows 4 items and navigation is correct

---

### Test Case 05: Pagination - Navigation

**Test Case ID**: TC-01-005  
**Scenario**: Pagination - navigating between pages  
**Priority**: Medium  
**Type**: Integration Test  

**Preconditions**:
- At least 8 delivered products exist
- First page of results is displayed

**Test Steps**:
1. Click "Volgende" (Next) button to go to page 2
2. Note products displayed on page 2
3. Click "Vorige" (Previous) button
4. Verify return to page 1

**Expected Results**:
- Page 2 displays next 4 products
- Products are different from page 1
- Returning to page 1 shows original products
- Smooth page transitions occur
- URL parameters update (page=1, page=2, etc.)

**Pass Criteria**: Navigation between pages works correctly

---

### Test Case 06: Date Validation

**Test Case ID**: TC-01-006  
**Scenario**: Date validation and error handling  
**Priority**: Medium  
**Type**: System Test  

**Preconditions**:
- Overview page is displayed

**Test Steps**:
1. Submit form with end date before start date
2. Submit form with invalid date format
3. Submit form with only start date
4. Submit form with only end date

**Expected Results**:
- Appropriate error messages displayed
- Application handles gracefully
- User can correct input and retry

**Pass Criteria**: Validation errors are handled appropriately

---

### Test Case 07: Data Sorting

**Test Case ID**: TC-01-007  
**Scenario**: Data sorting by Supplier name (A-Z)  
**Priority**: Medium  
**Type**: Integration Test  

**Preconditions**:
- Multiple suppliers have deliveries in date range
- Overview page displays results

**Test Steps**:
1. Examine supplier names in first column
2. Verify alphabetical ordering

**Expected Results**:
- Suppliers are listed in alphabetical order (A-Z)
- First supplier alphabetically is displayed first
- Sorting is case-insensitive

**Pass Criteria**: Data is correctly sorted by supplier name

---

### Test Case 08: Database Relationships

**Test Case ID**: TC-01-008  
**Scenario**: Data consistency and relationships  
**Priority**: Low  
**Type**: Unit Test  

**Preconditions**:
- Database contains test data

**Test Steps**:
1. Query ProductPerLeverancier for April 2023 deliveries
2. Verify each record has valid Product reference
3. Verify each record has valid Leverancier reference
4. Verify each record has valid date values

**Expected Results**:
- All foreign keys are valid
- No orphaned records exist
- Date values are consistent and correct
- IsActief flag is respected

**Pass Criteria**: All data relationships are intact

---

## 6. Test Execution

### Test Environment
- **Browser**: Chrome/Edge (latest version)
- **Server**: Laravel 11.x on PHP 8.4
- **Database**: MySQL 8.0
- **Test Data**: As specified in create_database.sql

### Test Schedule
- Unit Tests: Automated, run on each commit
- Integration Tests: Run after code merge
- System Tests: Run before release
- Acceptance Tests: Run for stakeholder approval

### Test Resources
- 1 QA Engineer
- 1 Database Administrator (for data setup)
- Development Environment
- Test Database

---

## 7. Test Criteria

### Pass Criteria
- All test cases pass successfully
- No critical defects remain
- All acceptance criteria from user story are met
- Stored procedures execute without errors
- Pagination functions correctly
- Data is accurate and complete

### Fail Criteria
- Any critical defect (blocking the feature)
- Data loss or corruption
- SQL errors in stored procedures
- Incorrect sorting or pagination
- Missing required information in views

---

## 8. Risks and Mitigation

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|-----------|
| Date filtering logic fails | Medium | High | Comprehensive date range testing |
| Pagination miscalculation | Medium | Medium | Unit tests for pagination math |
| Stored procedure errors | Medium | High | Test procedures manually first |
| Performance issues | Low | Medium | Monitor query times on large datasets |
| Data inconsistency | Low | High | Verify foreign key constraints |

---

## 9. Deliverables

- Test Plan (this document)
- Test Cases (specification above)
- Unit Test Code (DeliveredProductsControllerTest.php)
- Test Report (with results and screenshots)
- Test Data SQL Script (create_database.sql)

---

## 10. Sign-Off

| Role | Name | Signature | Date |
|------|------|-----------|------|
| QA Lead | [Name] | __________ | ________ |
| Project Manager | [Name] | __________ | ________ |
| Developer | [Name] | __________ | ________ |

---

## Appendix: Test Data Summary

### Products with Deliveries (April 2023)
- Mintnopjes: 2 deliveries (23 and 21 units)
- Schoolkrijt: 1 delivery (12 units)
- Honingdrop: 1 delivery (11 units)
- Zure Beren: 2 deliveries (16 and 23 units)
- Cola Flesjes: 1 delivery (45 units)
- Turtles: 1 delivery (30 units)
- Witte Muizen: 2 deliveries (12 and 23 units)
- Reuzen Slangen: 1 delivery (12 units)
- Zoute Rijen: 1 delivery (1 unit)
- Winegums: 1 delivery (24 units)
- Drop Munten: 2 deliveries (47 and 60 units)
- Kruis Drop: 1 delivery (45 units)
- Zoute Ruitjes: 1 delivery (23 units)
- Drop ninja's: 1 delivery (20 units)

**Total Deliveries**: 18 records in test date range
