CREATE OR REPLACE VIEW prof_vp_answer AS (
	SELECT 
	id,
	answer,
	status
	FROM prof_answer
	);
CREATE OR REPLACE VIEW prof_vp_competencies AS (
	SELECT 
	id,
	competencies,
	status
	FROM prof_competencies
	);
CREATE OR REPLACE VIEW prof_vp_criteria AS (
	SELECT 
	id,
	criteria,
	flag,
	description,
	status
	FROM prof_criteria
	);
CREATE OR REPLACE VIEW prof_vp_profilling AS (
	SELECT 
	p.id AS id,
	cr.id AS criteria_id,
	cr.criteria AS criteria,
	q.question AS question,
	q.id AS question_id,
	a.answer AS answer,
	a.id AS answer_id,
	c.competencies AS competencies,
	c.id AS competencies_id,
	p.status AS status
	FROM prof_profilling p
	LEFT JOIN prof_competencies c ON p.competencies = c.id
	LEFT JOIN prof_answer a ON p.answer = a.id
	LEFT JOIN prof_question q ON p.question = q.id
	LEFT JOIN prof_criteria cr ON p.criteria = cr.id
	);
CREATE OR REPLACE VIEW prof_vp_question AS (
	SELECT 
	id,
	sort,
	question,
	status
	FROM prof_question
	);
CREATE OR REPLACE VIEW prof_v_transaction AS (
	SELECT 
	id,
	user_id,
	email,
	name,
	phone,
	consultant,
	competencies,
	status,
	created_at AS created
	FROM prof_transaction
	);
CREATE OR REPLACE VIEW prof_v_user AS (
	SELECT 
	h.id AS id,
	name,
	email,
	date_of_birth,
	phone,
	gender,
	religion,
	marital_status,
	education,
	project_code,
	project_name,
	group_cos,
	current_companies,
	industry,
	work_title,
	level,
	competencies,
	h.created_at as created_at,
	h.updated_at as updated_at,
	h.status AS status
	FROM prof_user h
	LEFT JOIN prof_user_detils c ON h.id = c.user_id
	WHERE roll_id = 2
	);
CREATE OR REPLACE VIEW prof_v_admin AS (
	SELECT 
	u.id AS id,
	u.name AS name,
	email,
	r.name AS role,
	u.status AS status
	FROM prof_user u
	LEFT JOIN prof_role r ON u.roll_id = r.id
	WHERE roll_id != 2
	);
CREATE OR REPLACE VIEW prof_v_role AS (
	SELECT 
	id,
	name,
	status
	FROM prof_role
	);
CREATE OR REPLACE VIEW prof_vm_competencies AS (
	SELECT 
	id,
	type,
	value,
	status
	FROM prof_master WHERE type = 'competencies'
	);
CREATE OR REPLACE VIEW prof_vm_education AS (
	SELECT 
	id,
	type,
	value,
	status
	FROM prof_master WHERE type = 'education'
	);
CREATE OR REPLACE VIEW prof_vm_industry AS (
	SELECT 
	id,
	type,
	value,
	status
	FROM prof_master WHERE type = 'industry'
	);
CREATE OR REPLACE VIEW prof_vm_level AS (
	SELECT 
	id,
	type,
	value,
	status
	FROM prof_master WHERE type = 'level'
	);
CREATE OR REPLACE VIEW prof_vm_marital AS (
	SELECT 
	id,
	type,
	value,
	status
	FROM prof_master WHERE type = 'marital'
	);
CREATE OR REPLACE VIEW prof_vm_religion AS (
	SELECT 
	id,
	type,
	value,
	status
	FROM prof_master WHERE type = 'religion'
	);