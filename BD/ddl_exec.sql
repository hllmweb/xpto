-- create database xpto;
use xpto;
 
DELIMITER $$
/*
 * Usuários autenticados
 * */
create table  if not exists tb_Auth(
	IdAuth bigint not null auto_increment,
	Login varchar(50) not null,
	Password varchar(50) not null,
	Email varchar(150) not null,
	DtHrRegister datetime not null default now(),
	constraint email unique(Email),
	primary key(IdAuth)
);


/*
 * Url cadastradas associadas ao usuário cadastro
 * */
create table if not exists tb_Url(
	IdUrl bigint not null auto_increment,
	IdAuth bigint not null,
	StatusCode smallint null,
	Url varchar(250) not null,
	IpTerminal varchar(25) not null,
	DtHrRegister datetime not null default now(),
	primary key(IdUrl),
	constraint fk_auth_url
	foreign key(IdAuth) references tb_Auth(IdAuth)
);

/*
 * cadastra o monitoramento e retorno das informações
 * */
create table if not exists tb_LogMonitoring(
	IdMonitoring bigint not null auto_increment,
	IdUrl bigint not null,
	IdAuth bigint not null,
	StatusCode smallint not null,
	Body longtext not null,
	IpTerminal varchar(25) not null,
	DtHrMonitoring datetime not null default now(),
	primary key(IdMonitoring),
	constraint fk_url
	foreign key(IdUrl) references tb_Url(IdUrl) on delete cascade on update cascade,
	constraint fk_auth_monitoring
	foreign key(IdAuth) references tb_Auth(IdAuth) on delete cascade on update cascade
);

DELIMITER ;


/*importante para atualizar o status*/

create or replace trigger tg_after_insert 
after insert on tb_LogMonitoring
for each row 
begin
	update tb_Url set StatusCode = new.StatusCode
	where IdUrl = new.IdUrl and IdAuth = new.IdAuth;
end;



/*Stored Procedure de Auth e Insert*/
create procedure  if not exists sp_auth(
	p_operacao int,
	p_login varchar(50),
	p_password varchar(50),
	p_email varchar(100)
) 
begin
	/*	
	 * 
	 * p_operacao = 0 (verifica se existe email, caso não exista, efetua o cadastro)
	 * p_operacao = 1 (verifica se existe usuário)
	 * p_operacao = 2 (inserir usuários)
	 * */
	
	 case p_operacao
		 when 0 then
			if (select fn_email(p_email)) = 1 then 
				select 1 valor;  -- "E-Mail Já Cadastrado!"
			else
		 		select 0 valor;  -- "E-Mail Não Cadastrado!" 
		 	end if;
		when 1 then
		
				select a.IdAuth, a.Login, a.Password, a.Email, a.DtHrRegister 
				from tb_Auth a where a.Login = p_login and a.Password  = md5(p_password);
		
			
		when 2 then 
				insert into tb_Auth (Login, Password, Email) values (p_login, md5(p_password), p_email);
				select 'Cadastrado com sucesso!' mensagem;
	end case;
end;


/* realizar o insert do monitoramento*/
create procedure if not exists sp_monitoring(
	p_operacao int,
	p_opcao int,
	p_idauth bigint,
	p_idurl bigint,
	p_url varchar(250),
	p_statuscode smallint, 
	p_body longtext,
	p_ipterminal varchar(25)
)
begin
	/* p_opcao = 1 (lista apenas urls do id)
	 * p_opcao = 0 (lista todas as urls)
	 * 
	 * 
	 * p_operacao = 0 (lista urls em monitoramento por usuários)
	 * p_operacao = 1 (insere o status code e body de cada requisições)
	 * p_operacao = 2 (delete url e o log de monitoramento)
	 * p_operacao = 3 (insere url)
	 * */
	case p_operacao
		when 0 then
			select a.IdAuth, u.IdUrl, u.Url, u.StatusCode,
			m.Body, max(m.DtHrMonitoring) as DtHrMonitoring from tb_Auth a 
			join tb_Url u on u.IdAuth = a.IdAuth 
			left join tb_LogMonitoring m on m.IdUrl = u.IdUrl and m.IdAuth = a.IdAuth 
			where 
			((1 = p_opcao) and (a.IdAuth = p_idauth))
			or 
			((0 = p_opcao))
			group by a.IdAuth, u.StatusCode, u.IdUrl, u.Url;
	
		when 1 then
			insert into tb_LogMonitoring (idUrl, IdAuth, StatusCode, Body, IpTerminal) 
		 	values (p_idurl, p_idauth, p_statuscode, p_body, p_ipterminal);
		 	select 1 valor;
		when 2 then
		 	delete from tb_Url where IdAuth = p_idauth and IdUrl = p_idurl; 
		 	select 1 valor;
		when 3 then 
			insert into tb_Url (IdAuth, Url, IpTerminal) 
			values (p_idauth, p_url, p_ipterminal);
			select 1 valor;
	end case;
end;


/* função que verifica se já existe o email*/
create function fn_email(
	p_email varchar(100)
)
returns varchar(100)

begin
	declare final int default 0;
	declare v_result int;
	declare v_email varchar(100);
	

	declare cursor_acesso cursor for 
		select Email from tb_Auth where Email = p_email;
			
		declare continue handler for not found set final = 1;
				
	 	open cursor_acesso;
	 		fetch cursor_acesso into v_email;
	 		if not final then 
	 		 	set v_result = 1; -- 'E-Mail Já Existe!';
	 		else
	 			set v_result = 0; -- 'E-Mail Não Existe!';
	 		end if;
	 
	 	close cursor_acesso;
	return (v_result);
end;

DELIMITER ;


/*
 * Dados ficticio
 * */
insert into tb_Auth (Login, Password, Email) values 
('xxx',md5('123'),'xxx@gmail.com'),
('yyy',md5('123'),'yyy@gmail.com');



insert into tb_Url (IdAuth, Url, IpTerminal) values 
(1, 'https://www.globo.com', '127.0.0.1'),
(1, 'https://www.google.com','127.0.0.1'),
(2, 'https://www.hugomesquita.com.br','127.0.0.1');


