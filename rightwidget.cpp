#include "rightwidget.h"

RightWidget::RightWidget(QWidget *parent)
    : QWidget(parent)
{
    //VALUES:
    TotalNumber=0;
    FreeNumber=0;
    BookedNumber=0;
    BusyNumber=0;


    //NETWORKSTUFF
    Manager=new QNetworkAccessManager(this);

   // RefreshTimerOverflow();


    //BUTTONS:
    TakeBed=new QPushButton("Занять");
    FreeBookedBed=new QPushButton("Освободить");
    FreeBusyBed=new QPushButton("Освободить");

    //TIMERS
    RefreshTimer=new QTimer();


    //LABELS
    BedsLabel=new QLabel("Места");
    BedsLabel->setMaximumHeight(30);
    TotalNumberLabel=new QLabel("Всего");
    TotalNumberLabel->setMaximumHeight(30);
    FreeNumberLabel=new QLabel("Свободные");
    FreeNumberLabel->setMaximumHeight(30);
    BookedNumberLabel=new QLabel("Бронь");
    BookedNumberLabel->setMaximumHeight(30);
    BusyNumberLabel=new QLabel("Занято");
    BusyNumberLabel->setMaximumHeight(30);
    TotalNumberValue=new QLabel(QString::number(TotalNumber));
    TotalNumberValue->setFixedWidth(70);
    FreeNumberValue=new QLabel(QString::number(FreeNumber));
    FreeNumberValue->setFixedWidth(70);
    BookedNumberValue=new QLabel(QString::number(BookedNumber));
    BookedNumberValue->setFixedWidth(70);
    BusyNumberValue=new QLabel(QString::number(BusyNumber));
    BusyNumberValue->setFixedWidth(70);
    QFont font =QFont();
    font.setPointSize(16);
    BedsLabel->setFont(font);
    TotalNumberLabel->setFont(font);
    FreeNumberLabel->setFont(font);
    BookedNumberLabel->setFont(font);
    BusyNumberLabel->setFont(font);
    TotalNumberValue->setFont(font);
    FreeNumberValue->setFont(font);
    BookedNumberValue->setFont(font);
    BusyNumberValue->setFont(font);
    TakeBed->setFont(font);
    FreeBookedBed->setFont(font);
    FreeBusyBed->setFont(font);

    //SIGNAL->SLOT
    connect(TakeBed,SIGNAL(clicked()),this,SLOT(TakeBedSlot()));
    connect(FreeBookedBed,SIGNAL(clicked()),this,SLOT(FreeBookedBedSlot()));
    connect(FreeBusyBed,SIGNAL(clicked()),this,SLOT(FreeBusyBedSlot()));
    connect(RefreshTimer,SIGNAL(timeout()), this, SLOT(RefreshTimerOverflow()));
    connect(Manager, SIGNAL(finished(QNetworkReply*)),this, SLOT(replyFinished(QNetworkReply*)));



    //LAYOUTS
    QHBoxLayout* BookedLayout=new QHBoxLayout();
    BookedLayout->addWidget(TakeBed);
    BookedLayout->addWidget(FreeBookedBed);


    QGridLayout* MainLayout= new QGridLayout();
    MainLayout->setHorizontalSpacing(5);
    MainLayout->setVerticalSpacing(5);
    MainLayout->addWidget(BedsLabel,0,0);
    MainLayout->addWidget(TotalNumberLabel,1,0);
    MainLayout->addWidget(FreeNumberLabel,2,0);
    MainLayout->addWidget(BookedNumberLabel,3,0);
    MainLayout->addWidget(BusyNumberLabel,4,0);

    MainLayout->addWidget(TotalNumberValue,1,1);
    MainLayout->addWidget(FreeNumberValue,2,1);
    MainLayout->addWidget(BookedNumberValue,3,1);
    MainLayout->addWidget(BusyNumberValue,4,1);

    MainLayout->addLayout(BookedLayout,3,2);
    MainLayout->addWidget(FreeBusyBed,4,2);


    this->setLayout(MainLayout);

    setGeometry(0,200,500,100);

    RefreshTimer->start(1000);
}

void RightWidget::TakeBedSlot(){

    QString Query="http://informcosm.temp.swtest.ru/reserve_to_employed.php?scrubs_id="+QString::number(scrubs_id)+"&department_id="+QString::number(department_id);
    QUrl urlUser(Query);

    request=QNetworkRequest(urlUser);
    reply= Manager->get(request);
    connect( reply, SIGNAL(finished()),this, SLOT(replyFinished()));

}

void RightWidget::FreeBookedBedSlot(){
    QString Query="http://informcosm.temp.swtest.ru/reserve_to_free.php?scrubs_id="+QString::number(scrubs_id)+"&department_id="+QString::number(department_id);
    QUrl urlUser(Query);

    request=QNetworkRequest(urlUser);

    reply= Manager->get(request);
    connect( reply, SIGNAL(finished()),this, SLOT(replyFinished()));
}

void RightWidget::FreeBusyBedSlot(){
    QString Query="http://informcosm.temp.swtest.ru/employed_to_free.php?scrubs_id="+QString::number(scrubs_id)+"&department_id="+QString::number(department_id);
    QUrl urlUser(Query);

    request=QNetworkRequest(urlUser);

    reply= Manager->get(request);
    connect( reply, SIGNAL(finished()),this, SLOT(replyFinished()));
}

void RightWidget::CheckButtons(){
    if(BookedNumber==0){
        FreeBookedBed->setDisabled(true);
        TakeBed->setDisabled(true);
    }
    else{
        FreeBookedBed->setEnabled(true);
        TakeBed->setEnabled(true);
    }

    if(BusyNumber==0)
        FreeBusyBed->setDisabled(true);
    else
        FreeBusyBed->setEnabled(true);
}

void RightWidget::RefreshTimerOverflow()
{

    //TODO Ask Server for new bookings
    QString Query="http://informcosm.temp.swtest.ru/get_num_of_place.php?scrubs_id="+QString::number(scrubs_id)+"&department_id="+QString::number(department_id);
    //QUrl urlUser(Query);

    request=QNetworkRequest(QUrl(Query));

    reply= Manager->get(request);
    connect( reply, SIGNAL(finished()),this, SLOT(replyFinished()));

}

void RightWidget::StringParser(QString String){
    QStringList StringList = String.split("|");
    TotalNumber=StringList[0].toInt();
    BusyNumber=StringList[1].toInt();
    BookedNumber=StringList[2].toInt();
    FreeNumber=TotalNumber - BookedNumber - BusyNumber;

    SetLabels();
    CheckButtons();
}

void RightWidget::replyFinished()
{
    QNetworkReply *reply1 = qobject_cast<QNetworkReply *>(sender());
    QString content= reply1->readAll();
    if (content == "")
        return;
    StringParser(content);
}

void RightWidget::SetLabels()
{
    TotalNumberValue->setText(QString::number(TotalNumber));
    FreeNumberValue->setText(QString::number(FreeNumber));
    BookedNumberValue->setText(QString::number(BookedNumber));
    BusyNumberValue->setText(QString::number(BusyNumber));
}
