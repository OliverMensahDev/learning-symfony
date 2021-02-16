DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
`id` char(36) COLLATE utf8mb4_unicode_520_ci NOT NULL,
`product_id` char(36) COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT '(DC2Type:guid)',
`name` char(36) COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT '(DC2Type:guid)',
`price` char(36) COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT '(DC2Type:guid)',
`description` char(36) COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT '(DC2Type:guid)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
