Public Class Member
    Private _Name As String
    Private _Rank As String
    Private _Joined As String


    Public Property Name() As String
        Get
            Return Me._Name
        End Get
        Set(value As String)
            Me._Name = value
        End Set
    End Property

    Public Property Rank() As String
        Get
            Return Me._Rank
        End Get
        Set(value As String)
            Me._Rank = value
        End Set
    End Property

    Public Property Joined() As String
        Get
            Return Me._Joined
        End Get
        Set(value As String)
            Me._Joined = value
        End Set
    End Property

    Public Sub New(name As String, rank As String, joined As String)
        Me.Name = name
        Me.Rank = rank
        Me.Joined = joined
    End Sub
End Class