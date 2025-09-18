# Wedding Invitation Website Database Design Documentation

## Overview
This document provides a comprehensive explanation of the database design for the wedding invitation website. The design supports all sections of the website including couple information, event details, gallery, timeline, gifts, and guest interactions.

## Database Schema Explanation

### 1. Couples Table
The `couples` table is the central entity representing the wedding couple:
- `groom_name` and `bride_name`: Store the full names of the couple
- `wedding_date`: The main wedding date
- This table allows for multiple weddings to be managed in the same system

### 2. Persons Table
The `persons` table stores detailed information about each person in the couple:
- `role`: Identifies whether the person is the 'groom' or 'bride'
- `full_name`: Complete name of the person
- `image_url`: Path to the person's profile image
- `additional_info`: Any additional information about the person
- Linked to `couples` via foreign key relationship

### 3. PersonParents Table
The `person_parents` table contains information about each person's parents:
- `father_name` and `mother_name`: Names of the parents
- `father_status` and `mother_status`: Indicates if parents are alive or deceased (using the skull symbol in the HTML)
- Each person can have one set of parent information

### 4. WeddingEvents Table
The `wedding_events` table manages different events related to the wedding:
- `event_name`: Name of the event (e.g., "Main Ceremony", "Reception")
- `event_date`, `event_time`, `end_time`: Date and time details of the event
- A couple can have multiple events (engagement, wedding ceremony, reception, etc.)

### 5. Locations Table
The `locations` table stores venue information for wedding events:
- `venue_name`: Name of the venue
- `address`: Complete address of the venue
- `map_embed_url`: Google Maps embed URL for location display
- Each wedding event has one location

### 6. GalleryImages Table
The `gallery_images` table manages the photo gallery:
- `image_url`: Path to the full-size image
- `thumbnail_url`: Path to the thumbnail version
- `description`: Description of the image
- `sort_order`: Controls the display order of images
- Linked to wedding events, allowing different galleries for different events

### 7. TimelineEvents Table
The `timeline_events` table stores the couple's story timeline:
- `title`: Title of the timeline event
- `event_date`: Date of the event
- `description`: Description of what happened
- `image_url`: Image associated with the event
- `sort_order`: Controls chronological display order
- `is_inverted`: Controls layout display (alternating sides in the timeline)

### 8. BankAccounts Table
The `bank_accounts` table manages gift account information:
- `bank_name`: Name of the bank
- `account_number`: Account number for gifts
- `account_holder_name`: Name of the account holder
- `is_active`: Allows multiple accounts with the ability to enable/disable

### 9. Guests Table
The `guests` table stores information about invited guests:
- `name`: Guest's full name
- `email`: Guest's email address
- `phone`: Guest's phone number
- Allows for managing guest lists and communications

### 10. Invitations Table
The `invitations` table handles specific invitations sent to guests:
- `invitation_code`: Unique code for each invitation
- `is_attending`: RSVP status (Yes/No/Null)
- `responded_at`: Timestamp of when the RSVP was received
- Links guests to specific wedding events

### 11. QRCodes Table
The `qr_codes` table manages QR codes for invitations:
- `qr_data`: Data encoded in the QR code
- `qr_image_url`: URL to the QR code image
- Each invitation can have one QR code

### 12. GuestMessages Table
The `guest_messages` table stores messages from guests:
- `guest_name`: Name of the person sending the message
- `message`: Content of the message/wish
- `is_approved`: Flag for moderating messages before public display

## Relationships

### One-to-Many Relationships
1. **Couples → Persons**: One couple has two persons (bride and groom)
2. **Couples → WeddingEvents**: One couple can have multiple events
3. **Couples → TimelineEvents**: One couple has many timeline events
4. **WeddingEvents → GalleryImages**: One event can have many gallery images
5. **WeddingEvents → BankAccounts**: One event can have multiple gift accounts
6. **WeddingEvents → GuestMessages**: One event receives many messages
7. **WeddingEvents → Invitations**: One event can have many invitations
8. **Guests → Invitations**: One guest can receive many invitations
9. **Invitations → QRCodes**: One invitation has one QR code

### One-to-One Relationships
1. **Persons → PersonParents**: Each person has one set of parent information

### Many-to-Many Relationships
The current design doesn't require many-to-many relationships, but they could be added if needed:
- For example, if guests could be linked to multiple couples or events

## Design Considerations

### Flexibility
The design allows for:
- Multiple events per wedding (engagement, ceremony, reception)
- Multiple gift accounts
- Multiple gallery images
- Multiple timeline events
- Multiple guests and invitations

### Scalability
- Auto-incrementing primary keys
- Proper indexing through foreign keys
- Logical separation of concerns

### Data Integrity
- Foreign key constraints to maintain referential integrity
- Cascade delete where appropriate (deleting a couple removes all related data)
- Timestamps for audit trails

### Future Enhancements
The design can easily accommodate:
- Multiple weddings in the same system
- Additional metadata for any entity
- New features like guest dietary preferences, seating arrangements, etc.

## Usage Examples

### Creating a new wedding
1. Insert into `couples` table
2. Insert into `persons` table (bride and groom)
3. Insert into `person_parents` table for each person
4. Insert into `wedding_events` table
5. Insert into `locations` table for the event

### Adding gallery images
1. Insert into `gallery_images` table with `wedding_event_id`

### Handling RSVPs
1. Find invitation by code
2. Update `is_attending` and `responded_at` fields

### Displaying timeline
1. Select from `timeline_events` where `couple_id` matches, ordered by `sort_order`

This database design provides a robust foundation for the wedding invitation website while maintaining flexibility for future enhancements.