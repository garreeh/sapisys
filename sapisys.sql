/*
 Navicat Premium Data Transfer

 Source Server         : PersonalProjectDB
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : sapisys

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 11/03/2025 16:15:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `S_USERCODE` int NULL DEFAULT NULL,
  `S_USERNAME` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `S_PASSWORD` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `S_ACCESSNO` int NULL DEFAULT NULL,
  `S_STATUSXX` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CPU` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `S_PASSWORD_VIEW` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 0, 'RUEL', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 20, 'Active', '', '123123');
INSERT INTO `users` VALUES (2, 1, 'MITCH', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 20, 'Active', '', '123123');
INSERT INTO `users` VALUES (3, 2, 'JOJO C.', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 6, 'Active', '', '123123');
INSERT INTO `users` VALUES (4, 3, 'NORA', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 12, 'Active', '', '123123');
INSERT INTO `users` VALUES (5, 4, 'MARIZ', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 3, 'Active', '', '123123');
INSERT INTO `users` VALUES (6, 5, 'FHENG', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 6, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (7, 6, 'MELY', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 20, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (8, 7, 'ALLYN', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 8, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (9, 8, 'NANCY', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 8, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (10, 9, 'BOYSIE', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 3, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (11, 10, 'CHERRY', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 1, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (12, 11, 'BJG', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 8, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (13, 12, 'JHEN', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 0, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (14, 13, 'ANNA', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 0, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (15, 14, 'JUVEN', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 20, 'Active', '', '123123');
INSERT INTO `users` VALUES (16, 15, 'AVERY', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 20, 'Active', '', '123123');
INSERT INTO `users` VALUES (17, 16, 'DULCE', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 8, 'Active', '', '123123');
INSERT INTO `users` VALUES (18, 17, 'BADETH', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 6, 'Active', '', '123123');
INSERT INTO `users` VALUES (19, 18, 'PHENG', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 0, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (20, 19, 'MARGIE', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 12, 'Active', '', '123123');
INSERT INTO `users` VALUES (21, 20, 'NEW ACCT', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 3, 'Active', '', '123123');
INSERT INTO `users` VALUES (22, 21, 'WILSON', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 1, 'Active', '', '123123');
INSERT INTO `users` VALUES (23, 22, 'FHENG', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 6, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (24, 23, 'GERALDINE', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 10, 'Inactive', '', '123123');
INSERT INTO `users` VALUES (25, 24, 'INDEX', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 20, 'Active', '', '123123');
INSERT INTO `users` VALUES (26, 25, 'MJ', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 20, 'Active', '', '123123');
INSERT INTO `users` VALUES (27, 26, 'MIKE', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 20, 'Active', '', '123123');
INSERT INTO `users` VALUES (28, 27, 'FORTE', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 6, 'Active', '', '123123');
INSERT INTO `users` VALUES (29, 28, 'OJT1', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 1, 'Active', '', '123123');
INSERT INTO `users` VALUES (30, 29, 'OJT2', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 1, 'Active', '', '123123');
INSERT INTO `users` VALUES (31, 30, 'JM', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 10, 'Active', '', '123123');
INSERT INTO `users` VALUES (32, 31, 'RYAN', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 10, 'Active', '', '123123');
INSERT INTO `users` VALUES (33, 32, 'DAVE', '$2y$10$vtj3lvgROA.ecVm2oI2YnOrlhFzn1jNE/sMk72HTTH.ymfaBol9jW', 8, 'Active', '', '123123');

SET FOREIGN_KEY_CHECKS = 1;
