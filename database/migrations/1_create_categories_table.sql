CREATE TABLE `categories` (
    `id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `parent_id` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);
INSERT INTO `categories` (`id`, `name`, `parent_id`) 
VALUES
("1c2a3b4d-5e6f-7a8b-9c0d-1e2f3a4b5c6d", "Technology", NULL),
("2c3d4e5f-6a7b-8c9d-0e1f-2a3b4c5d6e7f", "Software Development", "1c2a3b4d-5e6f-7a8b-9c0d-1e2f3a4b5c6d"),
("3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f8a", "Hardware Engineering 2", "2c3d4e5f-6a7b-8c9d-0e1f-2a3b4c5d6e7f"),
("3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f82", "Hardware Engineering 3", "3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f8a"),
("4e5f6a7b-8c9d-0e1f-2a3b-4c5d6e7f8a9b", "Education", NULL),
("5f6a7b8c-9d0e-1f2a-3b4c-5d6e7f8a9b0c", "Higher Education", "4e5f6a7b-8c9d-0e1f-2a3b-4c5d6e7f8a9b"),
("6a7b8c9d-0e1f-2a3b-4c5d-6e7f8a9b0c1d", "K-12 Education", "4e5f6a7b-8c9d-0e1f-2a3b-4c5d6e7f8a9b"),
("7b8c9d0e-1f2a-3b4c-5d6e-7f8a9b0c1d2e", "Health & Wellness", NULL),
("8c9d0e1f-2a3b-4c5d-6e7f-8a9b0c1d2e3f", "Fitness & Nutrition", "7b8c9d0e-1f2a-3b4c-5d6e-7f8a9b0c1d2e"),
("9d0e1f2a-3b4c-5d6e-7f8a-9b0c1d2e3f4a", "Mental Health", "7b8c9d0e-1f2a-3b4c-5d6e-7f8a9b0c1d2e"),
("0e1f2a3b-4c5d-6e7f-8a9b-0c1d2e3f4a5b", "Arts & Entertainment", NULL),
("1f2a3b4c-5d6e-7f8a-9b0c-1d2e3f4a5b6c", "Visual Arts", "0e1f2a3b-4c5d-6e7f-8a9b-0c1d2e3f4a5b"),
("2a3b4c5d-6e7f-8a9b-0c1d-2e3f4a5b6c7d", "Performing Arts", "0e1f2a3b-4c5d-6e7f-8a9b-0c1d2e3f4a5b"),
("3b4c5d6e-7f8a-9b0c-1d2e-3f4a5b6c7d8e", "Science & Nature", NULL),
("4c5d6e7f-8a9b-0c1d-2e3f-4a5b6c7d8e9f", "Biology", "3b4c5d6e-7f8a-9b0c-1d2e-3f4a5b6c7d8e"),
("5d6e7f8a-9b0c-1d2e-3f4a-5b6c7d8e9f0a", "Physics", "3b4c5d6e-7f8a-9b0c-1d2e-3f4a5b6c7d8e"),
("6e7f8a9b-0c1d-2e3f-4a5b-6c7d8e9f0a1b", "Food & Cooking", NULL),
("7f8a9b0c-1d2e-3f4a-5b6c-7d8e9f0a1b2c", "Recipes", "6e7f8a9b-0c1d-2e3f-4a5b-6c7d8e9f0a1b"),
("8a9b0c1d-2e3f-4a5b-6c7d-8e9f0a1b2c3d", "Culinary Techniques", "6e7f8a9b-0c1d-2e3f-4a5b-6c7d8e9f0a1b"),
("9b0c1d2e-3f4a-5b6c-7d8e-9f0a1b2c3d4e", "Travel & Tourism", NULL),
("0c1d2e3f-4a5b-6c7d-8e9f-0a1b2c3d4e5f", "Destinations", "9b0c1d2e-3f4a-5b6c-7d8e-9f0a1b2c3d4e"),
("1d2e3f4a-5b6c-7d8e-9f0a-1b2c3d4e5f6a", "Travel Tips", "9b0c1d2e-3f4a-5b6c-7d8e-9f0a1b2c3d4e");