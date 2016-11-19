

#include <QtWidgets>

#include <QtNetwork/QNetworkAccessManager>
#include <QtNetwork/QNetworkRequest>
#include <QtNetwork/QNetworkReply>

//#CONSTANTS

//#

class RightWidget : public QWidget
{
    Q_OBJECT

public:
    RightWidget(QWidget *parent = 0);
    ~RightWidget(){}
    QLabel* BedsLabel;
    QLabel* TotalNumberLabel;
    QLabel* FreeNumberLabel;
    QLabel* BookedNumberLabel;
    QLabel* BusyNumberLabel;
    QLabel* TotalNumberValue;
    QLabel* FreeNumberValue;
    QLabel* BookedNumberValue;
    QLabel* BusyNumberValue;
    int TotalNumber;
    int FreeNumber;
    int BookedNumber;
    int BusyNumber;
    QPushButton* TakeBed;
    QPushButton* FreeBookedBed;
    QPushButton* FreeBusyBed;

    QTimer* RefreshTimer;

    QNetworkAccessManager* Manager;

    QNetworkReply* reply;
    QNetworkRequest request;

    int department_id=1;
    int scrubs_id=1;


    void CheckButtons();
    void StringParser(QString);
    void SetLabels();


 public slots:
    void TakeBedSlot();
    void FreeBookedBedSlot();
    void FreeBusyBedSlot();
    void RefreshTimerOverflow();
    void replyFinished();
};
