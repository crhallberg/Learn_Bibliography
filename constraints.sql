ALTER TABLE `publisher_location`
  ADD CONSTRAINT `publisher_location_publisher_id_fk` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`);

ALTER TABLE `work_agent`
ADD CONSTRAINT `work_agent_agenttype_id_fk` FOREIGN KEY(`agenttype_id`) REFERENCES `agenttype`(`id`);

ALTER TABLE `work_publisher`
  ADD CONSTRAINT `work_publisher_publisher_id_fk` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`);
  
ALTER TABLE `work`
  ADD CONSTRAINT `work_worktype_type_id_fk` FOREIGN KEY (`type_id`) REFERENCES `work_type` (`id`);