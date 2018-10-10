/* Ankita Date: 09-10-2018 */
ALTER TABLE `brands` ADD COLUMN LastDataRefresh DATETIME  DEFAULT NOW() AFTER NumberOfItem ;

ALTER TABLE `brand_seller_bridge` ADD COLUMN DataFeed VARCHAR(250) AFTER SellerID ;

/*Ankita Date:10-10-2018*/
DROP TABLE `seller_price_base`;
DROP TABLE `seller_price_type`;
DROP TABLE `seller_price_amount_type`;

/* vaibhav's Code: 10-10-2018*/
CREATE TABLE `field_mapping` (
  `meta_key` VARCHAR(150) DEFAULT NULL,
  `meta_value` VARCHAR(50000) DEFAULT NULL,
  `meta_status` INT(5) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;


CREATE TABLE `jp_formatted_data` (
  `process_log_id` INT(11) DEFAULT NULL,
  `UniqueItemID` VARCHAR(255) DEFAULT NULL,
  `PartName` VARCHAR(255) DEFAULT NULL,
  `Title` VARCHAR(255) DEFAULT NULL,
  `Price` VARCHAR(255) DEFAULT NULL,
  `Quantity` VARCHAR(255) DEFAULT NULL,
  `ProductCondition` VARCHAR(255) DEFAULT NULL,
  `Description` VARCHAR(255) DEFAULT NULL,
  `HTMLDescription` VARCHAR(255) DEFAULT NULL,
  `Category` VARCHAR(255) DEFAULT NULL,
  `SearchKeywords` VARCHAR(255) DEFAULT NULL,
  `Attributes` VARCHAR(255) DEFAULT NULL,
  `PartNumbers` VARCHAR(255) DEFAULT NULL,
  `ProductSKU` VARCHAR(255) DEFAULT NULL,
  `Brand` VARCHAR(255) DEFAULT NULL,
  `Photos` VARCHAR(255) DEFAULT NULL,
  `Videos` VARCHAR(255) DEFAULT NULL,
  `PartCompatibility` MEDIUMTEXT,
  `PositionOnVehicle` VARCHAR(255) DEFAULT NULL,
  `ACESPartTypeID` VARCHAR(255) DEFAULT NULL,
  `ACESSubCategoryID` VARCHAR(255) DEFAULT NULL,
  `PrivateNotes` VARCHAR(255) DEFAULT NULL,
  `AcceptOffers` VARCHAR(255) DEFAULT NULL,
  `AutoAcceptOfferPrice` VARCHAR(255) DEFAULT NULL,
  `MinimumOfferPrice` VARCHAR(255) DEFAULT NULL,
  `PaymentMethods` VARCHAR(255) DEFAULT NULL,
  `PaymentInstructions` VARCHAR(255) DEFAULT NULL,
  `Warranty` VARCHAR(255) DEFAULT NULL,
  `WarrantyPeriod` VARCHAR(255) DEFAULT NULL,
  `WarrantyPeriodType` VARCHAR(255) DEFAULT NULL,
  `ReturnsAccepted` VARCHAR(255) DEFAULT NULL,
  `ReturnPeriod` VARCHAR(255) DEFAULT NULL,
  `RefundAs` VARCHAR(255) DEFAULT NULL,
  `WarrantyandReturnPolicy` VARCHAR(255) DEFAULT NULL,
  `ShippingInsurance` VARCHAR(255) DEFAULT NULL,
  `InsurancePrice` VARCHAR(255) DEFAULT NULL,
  `HandlingTime` VARCHAR(255) DEFAULT NULL,
  `ShippingNotes` VARCHAR(255) DEFAULT NULL,
  `PackageType` VARCHAR(255) DEFAULT NULL,
  `PackageWeight` VARCHAR(255) DEFAULT NULL,
  `PackageLength` VARCHAR(255) DEFAULT NULL,
  `PackageWidth` VARCHAR(255) DEFAULT NULL,
  `PackageHeight` VARCHAR(255) DEFAULT NULL,
  `PackageMeasurementType` VARCHAR(255) DEFAULT NULL,
  `USShippingMethod` VARCHAR(255) DEFAULT NULL,
  `USShippingService1` VARCHAR(255) DEFAULT NULL,
  `USShippingService2` VARCHAR(255) DEFAULT NULL,
  `USShippingService3` VARCHAR(255) DEFAULT NULL,
  `USShippingService1Cost` VARCHAR(255) DEFAULT NULL,
  `USShippingService2Cost` VARCHAR(255) DEFAULT NULL,
  `USShippingService3Cost` VARCHAR(255) DEFAULT NULL,
  `USShippingService1AdditionalCost` VARCHAR(255) DEFAULT NULL,
  `USShippingService2AdditionalCost` VARCHAR(255) DEFAULT NULL,
  `USShippingService3AdditionalCost` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingMethod` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingSettingsSameAs` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingService1` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingService2` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingService3` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingService1Cost` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingService2Cost` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingService3Cost` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingService1AdditionalCost` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingService2AdditionalCost` VARCHAR(255) DEFAULT NULL,
  `CANADAShippingService3AdditionalCost` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingMethod` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingSettingsSameAs` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingService1` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingService2` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingService3` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingService1Cost` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingService2Cost` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingService3Cost` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingService1AdditionalCost` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingService2AdditionalCost` VARCHAR(255) DEFAULT NULL,
  `INTERNATIONALShippingService3AdditionalCost` VARCHAR(255) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;


CREATE TABLE `sema_data_process_log` (
  `id` INT(11) NOT NULL,
  `withFitmentFileName` VARCHAR(255) DEFAULT NULL,
  `withoutFitmentFileName` VARCHAR(255) DEFAULT NULL,
  `IsWithFitmentProcess` INT(11) DEFAULT NULL COMMENT '1:Yes, 0:No',
  `IsWithoutFitmentProcess` INT(11) DEFAULT NULL COMMENT '1:Yes, 0:No',
  `Brand` VARCHAR(255) DEFAULT NULL,
  `JobProcessingDate` VARCHAR(255) DEFAULT NULL,
  `CreatedDate` VARCHAR(255) DEFAULT NULL,
  `UpdatedDate` VARCHAR(255) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;


CREATE TABLE `without_fitment` (
  `process_log_id` INT(11) DEFAULT NULL,
  `b15_part_number` VARCHAR(255) DEFAULT NULL,
  `aces_part_type_id` VARCHAR(255) DEFAULT NULL,
  `title` VARCHAR(255) DEFAULT NULL,
  `d40_ret_retail` VARCHAR(255) DEFAULT NULL,
  `quantity` VARCHAR(255) DEFAULT NULL,
  `c10_abr_product_desc` VARCHAR(255) DEFAULT NULL,
  `c10_sho_product_desc` VARCHAR(255) DEFAULT NULL,
  `c10_inv_product_desc` VARCHAR(255) DEFAULT NULL,
  `c10_def_aaia_part_type_desc` VARCHAR(255) DEFAULT NULL,
  `c10_lab_label_desc` VARCHAR(255) DEFAULT NULL,
  `c10_des_product_desc` VARCHAR(255) DEFAULT NULL,
  `c10_shp_shipping_desc` VARCHAR(255) DEFAULT NULL,
  `c10_sla_slang_desc` VARCHAR(255) DEFAULT NULL,
  `c10_uns_un_spsc_desc` VARCHAR(255) DEFAULT NULL,
  `c10_vmr_vmrs_desc` VARCHAR(255) DEFAULT NULL,
  `c10_ext_product_desc` VARCHAR(255) DEFAULT NULL,
  `c10_mkt_marketing_desc` VARCHAR(255) DEFAULT NULL,
  `b10_item_level_gtin` VARCHAR(255) DEFAULT NULL,
  `b25_brand_label` VARCHAR(255) DEFAULT NULL,
  `p05_lgo` VARCHAR(255) DEFAULT NULL,
  `p05_p04` VARCHAR(255) DEFAULT NULL,
  `year` VARCHAR(255) DEFAULT NULL,
  `make` VARCHAR(255) DEFAULT NULL,
  `model` VARCHAR(255) DEFAULT NULL,
  `e10_ws1` VARCHAR(255) DEFAULT NULL,
  `payment_methods` VARCHAR(255) DEFAULT NULL,
  `d15_jbr_jobber` VARCHAR(255) DEFAULT NULL,
  `d40_jbr_jobber` VARCHAR(255) DEFAULT NULL,
  `position` VARCHAR(255) DEFAULT NULL,
  `h40_uom_for_dimensions` VARCHAR(255) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;


CREATE TABLE `with_fitment` (
  `process_log_id` INT(11) DEFAULT NULL,
  `b15_part_number` VARCHAR(255) DEFAULT NULL,
  `aces_part_type_id` VARCHAR(255) DEFAULT NULL,
  `title` VARCHAR(255) DEFAULT NULL,
  `d40_ret_retail` VARCHAR(255) DEFAULT NULL,
  `quantity` VARCHAR(255) DEFAULT NULL,
  `c10_abr_product_desc` VARCHAR(255) DEFAULT NULL,
  `c10_sho_product_desc` VARCHAR(255) DEFAULT NULL,
  `c10_inv_product_desc` VARCHAR(255) DEFAULT NULL,
  `c10_def_aaia_part_type_desc` VARCHAR(255) DEFAULT NULL,
  `c10_lab_label_desc` VARCHAR(255) DEFAULT NULL,
  `c10_des_product_desc` VARCHAR(255) DEFAULT NULL,
  `c10_shp_shipping_desc` VARCHAR(255) DEFAULT NULL,
  `c10_sla_slang_desc` VARCHAR(255) DEFAULT NULL,
  `c10_uns_un_spsc_desc` VARCHAR(255) DEFAULT NULL,
  `c10_vmr_vmrs_desc` VARCHAR(255) DEFAULT NULL,
  `c10_ext_product_desc` VARCHAR(255) DEFAULT NULL,
  `c10_mkt_marketing_desc` VARCHAR(255) DEFAULT NULL,
  `b10_item_level_gtin` VARCHAR(255) DEFAULT NULL,
  `b25_brand_label` VARCHAR(255) DEFAULT NULL,
  `p05_lgo` VARCHAR(255) DEFAULT NULL,
  `p05_p04` VARCHAR(255) DEFAULT NULL,
  `year` VARCHAR(255) DEFAULT NULL,
  `make` VARCHAR(255) DEFAULT NULL,
  `model` VARCHAR(255) DEFAULT NULL,
  `e10_ws1` VARCHAR(255) DEFAULT NULL,
  `payment_methods` VARCHAR(255) DEFAULT NULL,
  `d15_jbr_jobber` VARCHAR(255) DEFAULT NULL,
  `d40_jbr_jobber` VARCHAR(255) DEFAULT NULL,
  `position` VARCHAR(255) DEFAULT NULL,
  `h40_uom_for_dimensions` VARCHAR(255) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;


/*Ankita Date: 10-10-2018*/
CREATE DATABASE `sema_data_tool`;

RENAME TABLE 
`wire_frames`.`brand_price_adjustment_bridge` TO `sema_data_tool`.`brand_price_adjustment_bridge`,
`wire_frames`.`brand_seller_bridge` TO `sema_data_tool`.`brand_seller_bridge`,
`wire_frames`.`brands` TO `sema_data_tool`.`brands`,
`wire_frames`.`field_mapping` TO `sema_data_tool`.`field_mapping`,
`wire_frames`.`jp_formatted_data` TO `sema_data_tool`.`jp_formatted_data`,
`wire_frames`.`seller_brands_jp_update_data` TO `sema_data_tool`.`seller_brands_jp_update_data`,
`wire_frames`.`sellers` TO `sema_data_tool`.`sellers`,
`wire_frames`.`sema_brand_class_bridge` TO `sema_data_tool`.`sema_brand_class_bridge`,
`wire_frames`.`sema_class` TO `sema_data_tool`.`sema_class`,
`wire_frames`.`sema_data_process_log` TO `sema_data_tool`.`sema_data_process_log`,
`wire_frames`.`users` TO `sema_data_tool`.`users`,
`wire_frames`.`wire_frame_details` TO `sema_data_tool`.`wire_frame_details`,
`wire_frames`.`with_fitment` TO `sema_data_tool`.`with_fitment`,
`wire_frames`.`without_fitment` TO `sema_data_tool`.`without_fitment`;

ALTER TABLE `brands` ADD COLUMN `SemaBrandAlias` VARCHAR(150) AFTER `Name`;